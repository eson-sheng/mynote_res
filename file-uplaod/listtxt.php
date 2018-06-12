<?php

// �ݹ��ȡ������������νṹ
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
        // is_dir���ܴ���utf-8���룬��˽������յĽ������utf-8��¼
        $path = "$directory/$file";
        if (is_dir($path)) {
            if($recur) {
                $filename = pathinfo($path)["filename"];
                // ���˵�.git,.svn��filenameΪ�յģ�һ��Ϊ���أ��ļ���
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
    // ��ȡҳ�����
    // root��Ҫɨ��ĸ�Ŀ¼
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
