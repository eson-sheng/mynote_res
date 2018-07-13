<?php
include_once 'config.php';
include_once 'pdo.php';
include_once "../config.php";

$log_path = $log_paths[$sign - 1];
$indexfile_path = "./last_end_index$sign.txt";
if (!file_exists($indexfile_path)) {
    file_put_contents($indexfile_path, 0);
}
$last_end_index = file_get_contents($indexfile_path);
$content = file_get_contents($log_path, false, null, $last_end_index);
if ($content === '') {
    die("日志 $log_path 没有更新内容。");
}
$last_end_index += strlen($content);
file_put_contents($indexfile_path, $last_end_index);

$lines = explode("\n", $content);
$countLines = count($lines);

$M = new PDOModel();
