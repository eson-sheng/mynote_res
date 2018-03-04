<?php

$log_path = "test_php.txt";

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
	date_default_timezone_set('Asia/Shanghai');
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}

$file = fopen("ct.txt", "a+");
$file_ct_log = $file;

// comment out this if you DO NOT want to separate to tow ct files.
$file_ct_log = fopen("ct_log.txt", "a+");

function get_prefix() {
    Global $ip, $pid;
    if(!isset($ip)) {
        $pid = getmypid();
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $pid.' '.$ip.' '.date("m-d H:i:s ");
}

function CT($content) {
    // turn off CT if and only if config_CT_off exists!
    Global $CT_off;
    if(!isset($CT_off)) {
        $CT_off = file_exists(APPPATH.'/config/config_CT_off');
    }
    if($CT_off)
        return;

    Global $file, $last_time, $first_time,$is_first;
    // 通过stack trace计算缩进
    $array =debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
    $all_out = get_prefix().str_pad("", count($array)-2, " ").$content;
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

    fwrite($file, $all_out);

    $last_time=$cur_time;
}

function CT_log($content = "", $path = NULL) {
    Global $file_ct_log;
    $content = get_prefix().print_r($content, true)."\n";
    if($path) {
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
            if ($code == 301) {
                $url = curl_get_header($ch, $response, "Location");
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
            $content = "invoke error[" . curl_error($ch) . "]";
        }
        curl_close($ch);
        return $content;
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

?>
