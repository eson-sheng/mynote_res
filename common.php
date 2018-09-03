<?php

global $ct_path, $ct_log_path;
$log_path = "test_php.txt";
// 是否先log到buffer，再通过CT_flush()一次性写入文件
$ct_log_buffer = true;
$CT_off = true;
$request_num = str_pad(rand(0, 0x7fffffff), 10, "0", STR_PAD_LEFT);
$CT_format = "";

if ($ct_path) {
    $dir = dirname($ct_path);
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    $file = fopen($ct_path, "a+");
    $file_ct_log = $file;
}
if ($ct_log_path) {
    $dir = dirname($ct_log_path);
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    $file_ct_log = fopen($ct_log_path, "a+");
}

$ct_buffer = [];

$path_my = __DIR__ . "/common.my.php";
if (is_file($path_my)) {
    require $path_my;
}

function clear_log() {
	Global $log_path;
	unlink($log_path);
}

function clog($content, $with_lf = true) {
	Global $log_path;
	$file = fopen($log_path,"a+");
	fwrite($file, $content);
	CT_log($content);
	if($with_lf) {
		fwrite($file, "\n");
		CT_log("\n");
	}
	fclose($file);

}

function get_safe($obj, $key, $def = NULL) {
	if(isset($obj[$key])) {
		return $obj[$key];
	}
	return $def;
}

function get_stack_trace($title = "") {
	$html = "=================stack trace:".$title."\n";
	$array =debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
	foreach($array as $row) {
		$html .= sprintf("file:%s, line:%d, class:%s, function:%s\n",
			get_safe($row, 'file'), get_safe($row, 'line'), get_safe($row, 'class'), get_safe($row, 'function'));
	}
	return $html;
}

function log_stack_trace($title = "") {
	clog(get_stack_trace($title));
}

// error handler function with stack trace.
// use like this:
// $old_error_handler = set_error_handler("err_handler");
function err_handler($errno, $errstr, $errfile, $errline)
{
	$errno_map = array(1 => "E_ERROR", 2 => "E_WARNING", 4 => "E_PARSE", 8 => "E_NOTICE",
		16 => "E_CORE_ERROR", 32 => "E_CORE_WARNING", 64 => "E_COMPILE_ERROR",
		128 => "E_COMPILE_WARNING", 256 => "E_USER_ERROR", 512 => "E_USER_WARNING", 
		1024 => "E_USER_NOTICE", 2048 => "E_STRICT", 4096 => "E_RECOVERABLE_ERROR",
		8192 => "E_DEPRECATED", 16384 => "E_USER_DEPRECATED", 32767 => "E_ALL");
	clog(sprintf("------------ %s(%d), msg:%s", $errno_map[$errno], $errno, $errstr));
	log_stack_trace("");
	/* Don't execute PHP internal error handler */
	return true;
}

// 获取当前系统时间，返回float格式，单位：秒
function get_time() {
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}

function get_prefix() {
    /*
    return "";
    Global $ip, $pid;
    if(!isset($ip)) {
        $pid = getmypid();
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $pid.' '.$ip.' '.date("m-d H:i:s ");
    */
    list($usec, $sec) = explode(" ", microtime());
    return date("m-d H:i:s ", $sec) . $usec . ": ";
}

function CT($content) {
    Global $CT_off, $file;
    if($CT_off || !$file)
        return;

    Global $last_time, $first_time, $is_first, $ct_log_buffer, $ct_buffer, $request_num, $CT_format;
    if ($CT_format == "raw") {
        $all_out = $content . "\n";
    } else {
        // 通过stack trace计算缩进
        $array =debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $ignore_count = 0;
        $count = count($array);
        $ignore_names = ["call_user_func_array", "call_user_func", "spl_autoload_call"];
        $ignore_classes = ["ReflectionClass"];
        for ($i = 2; $i < $count; $i++) {
            $frame = $array[$i];
            if (in_array($frame["function"], $ignore_names) || isset($frame["class"]) && in_array($frame["class"], $ignore_classes)) {
                $ignore_count++;
            }
        }
        $all_out = /*get_prefix() .*/ str_pad("", $count - 2 - $ignore_count, " ") . $request_num . " " . $content;
        $cur_time=get_time();
        if(!$is_first) {
            $is_first = true;
            $last_time = $first_time = $cur_time;
        }
        $total_time=$cur_time-$first_time;
        $delta_time=$cur_time-$last_time;
        $overtime_flag = "";
        // 添加超时标记
        if($delta_time * 1000 > 10)
            $overtime_flag = "----overtime";

        $all_out = $all_out." cur_time: $cur_time, total_time: $total_time, delta_time: $delta_time $overtime_flag\n";
        $last_time=$cur_time;
    }

    if ($ct_log_buffer === true) {
        $ct_buffer[] = $all_out;
    } else {
        fwrite($file, $all_out);
    }
}

/**
 * 将buffer的CT内容写入文件
 * @param boolean turn_off_buffer, 完成后是否关闭buffer，以保证通过register_shutdown_function等调用的函数能够被输出
 */
function CT_flush($turn_off_buffer)
{
    global $file, $ct_buffer, $ct_log_buffer;
    if (!$file) {
        return;
    }
    fwrite($file, join("", $ct_buffer));
    $ct_buffer = [];
    $ct_log_buffer = !$turn_off_buffer;
}

function CT_log($content = "", $path = NULL) {
    Global $file_ct_log;
    if (!$file_ct_log && !$path) {
        return;
    }
    $content = get_prefix().print_r($content, true)."\n";
    if($path) {
        file_create_path($path);
        $file = fopen($path, "a+");
        if($file) {
            fwrite($file, $content);
            fclose($file);
        }
    }
    else {
        fwrite($file_ct_log, $content);
    }
}

/*
    获取指定的http response header 值。
    eg：
    HTTP/1.1 200 OK
    Server: Tengine/2.1.2
    Date: Sun, 02 Apr 2017 02:49:34 GMT
    Content-Type: text/html; charset=gb2312
    Content-Length: 124378
    Connection: keep-alive
    Cache-Control: private
    X-AspNetMvc-Version: 4.0
    X-AspNet-Version: 4.0.30319
*/
function curl_get_header($ch, $response, $key)
{
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $header_size);
    // header processing
    $header_arr = explode("\r\n", $header);

    $value = "";
    $key .= ":";
    foreach ($header_arr as $entry) {
        if (!strncmp($entry, $key, strlen($key))) {
            $value = trim(substr($entry, strlen($key)));
            break;
        }
    }
    return $value;
}

// 获取response状态码
function curl_get_status($ch, $response)
{
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $header_size);
    $header_arr = explode("\r\n", $header);
    return explode(" ", $header_arr[0])[1];
}

function startsWith($haystack, $needle)
{
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}

// http 301 is handled.
function http_get_core($url, &$status = null)
{
    CT_log("-----------http_get:" . $url);
    $ch = curl_init();
    $status = -1;

    // 301 最多嵌套3次。
    for ($i = 0; $i < 3; $i++) {
        $options = array(
            CURLOPT_HEADER => 1,
            CURLOPT_POST => 0,            // 请求方式为POST
            CURLOPT_URL => $url,      // 请求URL
            CURLOPT_RETURNTRANSFER => 1,  // 获取请求结果
            CURLOPT_TIMEOUT_MS => 30000,    // 超时时间(ms)
            CURLOPT_POSTFIELDS => http_build_query(array()), // 注入接口参数
            CURLOPT_SSL_VERIFYPEER => 0,  // 不验证证书
        );
        curl_setopt_array($ch, $options);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate"); // 百度不支持
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        if (($response = curl_exec($ch))) {
            // 有的网站header、<head>指定的编码不一致，会导致乱码。因此如果有编码信息，将其转送到client。
            $content_type = curl_get_header($ch, $response, "Content-Type");
            if($content_type) {
                header("Content-Type: " . $content_type);
            }

            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $status = $code = curl_get_status($ch, $response);
            if ($code == 301 || $code == 302) {
                $redirect_url = curl_get_header($ch, $response, "Location");
                $parsed_re = parse_url($redirect_url);
                if(isset($parsed_re["host"])) {
                    $url = $redirect_url;
                }
                else {
                    $parsed = parse_url($url);
                    if(startsWith($redirect_url, "/")) {
                        $url = $parsed["schema"]. "://" . $parsed["host"] . $redirect_url;
                    }
                    else {
                        // TODO 相对路径拼接
                        $content =  "relative path TODO";
                        curl_close($ch);
                        return $content;
                    }
                }
                continue;
            } else if ($code == 404) {
                header("Status: 404 Not Found");
                $msg = array(
                    "status" => 404
                );
                $content = "<p id='http_util_message_block' style='display: none'>" . json_encode($msg) . "</p>";
                $content .= "404, not found!";
            } else if ($code == 200) {
                $content = substr($response, $header_size);
            } else {
                $content = "http error, code=" . $code . "\n" . substr($response, $header_size);
            }
        } else {
            $msg = array(
                "status" => -1
            );
            $content = "<p id='http_util_message_block' style='display: none'>" . json_encode($msg) . "</p>";
            $content .= "invoke error[" . curl_error($ch) . "]";
        }
        curl_close($ch);
        return $content;
    }
}

// 递归为path创建必要的路径
function file_create_path($path)
{
    $dir = dirname($path);
    if ($dir && !file_exists($dir)) {
        mkdir($dir, 0755, true);
    }
}

// $save_path 需要gbk编码
function file_save($content, $save_path, $append)
{
    $dir = dirname($save_path);
    if (!file_exists($dir)) {
        mkdir($dir, 0644, true);
    }
    if ($append) {
        $file = fopen($save_path, "a+");
        if ($file) {
            fwrite($file, $content);
            fclose($file);
        }
    } else {
        file_put_contents($save_path, $content);
    }
}

// 默认的curl封装
function curl_do($url, $close_after_use = true)
{
    CT_log("curl_do: " . $url);
    $ch = curl_init();

    $options = array(
        CURLOPT_HEADER => 0,
        CURLOPT_POST => 0,            // 请求方式为POST
        CURLOPT_URL => $url,      // 请求URL
        CURLOPT_RETURNTRANSFER => 1,  // 获取请求结果
        CURLOPT_TIMEOUT_MS => 30000,    // 超时时间(ms)
        CURLOPT_POSTFIELDS => http_build_query(array()), // 注入接口参数
        CURLOPT_SSL_VERIFYPEER => 0,  // 不验证证书
    );

    curl_setopt_array($ch, $options);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    $response = curl_exec($ch);
    $err = curl_error($ch);
    if ($err) {
        CT_log("curl error: " . $err);
    }
    if ($close_after_use) {
        curl_close($ch);
    }
    return array("handle" => $ch, "response" => $response, "err" => $err);
}

/**
 * url拼接，没有处理user，pass两个components
 * 详细定义参见单元测试
 * @param $url
 * @param $base
 * @return string
 */
function get_absolute_url($url, $base)
{
    // 两种情况直接返回$url:
    if (!$base)
        return $url;
    $url_host = parse_url($url, PHP_URL_HOST);
    if ($url_host) {
        return $url;
    }

    $base_parsed = parse_url($base);
    $base_scheme = get_safe($base_parsed, "scheme", "");
    $base_host = get_safe($base_parsed, "host", "");
    $base_port = isset($base_parsed["port"]) ? ":" . $base_parsed["port"] : "";
    $base_path = get_safe($base_parsed, "path");

    if ($base_host) {
        $base_calc = $base_scheme . "://" . $base_host . $base_port;
        if (startsWith($url, "/")) {
            return $base_calc . $url;
        } else if ($base_path) {
            $pos = strrpos($base_path, "/");
            if ($pos !== false) {
                $dir = substr($base_path, 0, $pos + 1); // with last "/"
                return $base_calc . $dir . $url;
            } else {
                return $base_calc . "/" . $url;
            }
        } else {
            return $base_calc . "/" . $url;
        }
    } else {
        if (startsWith($url, "/")) {
            return $url;
        } else if ($base_path) {
            $pos = strrpos($base_path, "/");
            if ($pos !== false) {
                $dir = substr($base_path, 0, $pos + 1); // with last "/"
                return $dir . $url;
            } else {
                return $url;
            }
        } else {
            return $url;
        }
    }
}

function get_absolute_url_tests()
{
    // empty tests
    $tests[] = [null, null, null];
    $tests[] = ["", null, ""];
    $tests[] = [null, "", null];
    $tests[] = ["", "", ""];

    $tests[] = [null, "/", "/"];
    $tests[] = [null, "/a", "/"];
    $tests[] = [null, "/a/", "/a/"];

    $tests[] = ["a.html", "b", "a.html"];
    $tests[] = ["a.html", "", "a.html"];
    $tests[] = ["a.html", "/", "/a.html"];
    $tests[] = ["a/b/c/a.html", "http://1.1.1.1", "http://1.1.1.1/a/b/c/a.html"];
    $tests[] = ["a.html", "http://1.1.1.1:83", "http://1.1.1.1:83/a.html"];
    $tests[] = ["a.html", "http://1.1.1.1:83/", "http://1.1.1.1:83/a.html"];
    $tests[] = ["a.html", "http://1.1.1.1:83/a/b", "http://1.1.1.1:83/a/a.html"];
    $tests[] = ["a.html", "http://1.1.1.1:83/?", "http://1.1.1.1:83/a.html"];
    $tests[] = ["a.html", "http://1.1.1.1:83?", "http://1.1.1.1:83/a.html"];
    $tests[] = ["a.html", "http://1.1.1.1:83?a=b", "http://1.1.1.1:83/a.html"];
    $tests[] = ["a.html", "https://1.1.1.1:83?a=b#1", "https://1.1.1.1:83/a.html"];
    $tests[] = ["a.html", "www.baidu.com?a=b#1", "a.html"]; // www被认为是path

    // starts with "/"
    $tests[] = ["/a.html", "b", "/a.html"];
    $tests[] = ["/a.html", "", "/a.html"];
    $tests[] = ["/a.html", "/", "/a.html"];
    $tests[] = ["/a/b/c/a.html", "http://1.1.1.1", "http://1.1.1.1/a/b/c/a.html"];
    $tests[] = ["/a.html", "http://1.1.1.1:83", "http://1.1.1.1:83/a.html"];
    $tests[] = ["/a.html", "http://1.1.1.1:83/", "http://1.1.1.1:83/a.html"];
    $tests[] = ["/a.html", "http://1.1.1.1:83/a/b", "http://1.1.1.1:83/a.html"];
    $tests[] = ["/a.html", "http://1.1.1.1:83/?", "http://1.1.1.1:83/a.html"];
    $tests[] = ["/a.html", "http://1.1.1.1:83?", "http://1.1.1.1:83/a.html"];
    $tests[] = ["/a.html", "http://1.1.1.1:83?a=b", "http://1.1.1.1:83/a.html"];
    $tests[] = ["/a.html", "https://1.1.1.1:83?a=b#1", "https://1.1.1.1:83/a.html"];
    $tests[] = ["/a.html", "www.baidu.com?a=b#1", "/a.html"]; // www被认为是path

    $r = true;
    foreach ($tests as $test) {
        $abs = get_absolute_url($test[0], $test[1]);
        echo $abs . "\n";
        if ($abs !== $test[2]) {
            $r = false;
            break;
        }
    }
    echo "pass: " . $r . "\n";

    // return self tests
    $tests_self = [];
    $tests_self[] = ["http://test.com/a.html", "b", ""];
    $tests_self[] = ["http://test.com/a.html", "", ""];
    $tests_self[] = ["http://test.com/a.html", "/", ""];
    $tests_self[] = ["http://test.com/a/b/c/a.html", "http://1.1.1.1", ""];
    $tests_self[] = ["http://test.com/a.html", "http://1.1.1.1:83", ""];
    $tests_self[] = ["http://test.com/a.html", "http://1.1.1.1:83/", ""];
    $tests_self[] = ["http://test.com/a.html", "http://1.1.1.1:83/a/b", ""];
    $tests_self[] = ["http://test.com/a.html", "http://1.1.1.1:83/?", ""];
    $tests_self[] = ["http://test.com/a.html", "http://1.1.1.1:83?", ""];
    $tests_self[] = ["http://test.com/a.html", "http://1.1.1.1:83?a=b", ""];
    $tests_self[] = ["http://test.com/a.html", "https://1.1.1.1:83?a=b#1", ""];
    $tests_self[] = ["http://test.com/a.html", "www.baidu.com?a=b#1", ""]; // www被认为是path

    echo "-------------------return self test--------:\n";
    $r = true;
    foreach ($tests_self as $test) {
        $abs = get_absolute_url($test[0], $test[1]);
        echo $abs . "\n";
        if ($abs !== $test[0]) {
            $r = false;
            break;
        }
    }
    echo "pass: " . $r . "\n";
}

// 尝试gbk、utf-8两种编码；优先尝试传入编码
function is_file_ex($path)
{
    if (is_file($path)) {
        return true;
    }
    $enc = mb_detect_encoding($path, "gb2312", true);
    if ($enc === 'EUC-CN') {
        $path2 = iconv("gbk", "utf-8", $path);
    } else {
        $path2 = iconv("utf-8", "gbk", $path);
    }
    return is_file($path2);
}

// 尝试gbk、utf-8两种编码；优先尝试传入编码
function file_get_contents_ex($path)
{
    if (is_file($path)) {
        return file_get_contents($path);
    }
    $enc = mb_detect_encoding($path, "gb2312", true);
    if ($enc === 'EUC-CN') {
        $path2 = iconv("gbk", "utf-8", $path);
    } else {
        $path2 = iconv("utf-8", "gbk", $path);
    }
    if (is_file($path2)) {
        return file_get_contents($path2);
    }
    return false;
}

// 创建文件lock，如果路径不存在则创建之
function create_file_lock($path, &$output = null)
{
    file_create_path($path);
    $f = null;
    // 不使用"@"，这样忽略文件存在的报错，其他异常返回（如权限问题）
    try {
        $f = fopen($path, "x");
    } catch (Exception $e) {
        $msg = $e->getMessage();
        if (strpos($msg, "File exists") === false && strpos($msg, "文件已存在") === false) {
            $output = $e->getMessage() . "\n" . $e->getTraceAsString();
        }
    }
    return $f;
}

// 关闭、释放文件lock
function release_file_lock($f, $path)
{
    if ($f) {
        fclose($f);
        unlink($path);
    }
}
?>
