<?php

// 递归获取，结果保留树形结构
function list_files_recur($directory, $recur, $dir_only)
{
    if (!is_dir($directory)) {
        return;
    }
    $current = [];
    $files = [];
    $dirs = [];
    $cur_dir = dir($directory);
    while ($file = $cur_dir->read()) {
        if ($file === "." || $file === "..") {
            continue;
        }
        $file_utf = $file;
        // is_dir不能传入utf-8编码，因此仅在最终的结果中以utf-8记录
        $path = "$directory/$file";
        if (is_dir($path)) {
            if($recur) {
                $filename = pathinfo($path)["filename"];
                // 过滤掉.git,.svn等filename为空的（一般为隐藏）文件夹
                if ($filename) {
                    $dirs[$file_utf] = list_files_recur($path, True, $dir_only);
                }
            }
        } else {
            $tmp = strtolower($file_utf);
            if (endsWith($tmp, ".txt")) {
                $files[] = $file_utf;
            }
        }
    }
    if (!$dir_only) {
        $current["files"] = $files;
    }
    $current["dirs"] = $dirs;
    $sub_count = 0;
    foreach($dirs as $dir) {
        $sub_count += $dir["count"];
    }
    $current["count"] = count($files) + $sub_count;
    $cur_dir->close();
    return $current;
}

function scan()
{
    // 获取页面参数
    // root：要扫描的根目录
    $root = __DIR__ . "/upload";
    $root = str_replace("\\", "/", $root);
    $result = list_files_recur($root, false, false);
    $json = json_encode($result["files"]);
    echo $json;
}

function get_safe($obj, $key, $def = NULL) {
    if(isset($obj[$key])) {
        return $obj[$key];
    }
    return $def;
}

function startsWith($haystack, $needle)
{
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    $start = $length * -1; //negative
    return (substr($haystack, $start, $length) === $needle);
}

scan();
