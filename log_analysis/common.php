<?php
include_once 'pdo.php';
include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/../common.php";

$log_path = get_safe($_REQUEST, "logpath", "logs.txt");
if(is_dir($log_path)){
    $log_path = $log_path . '/' . date('Ymd') . '.log';
}
$indexfile_path = "./last_end_index.txt";
if (!file_exists($indexfile_path)) {
    file_put_contents($indexfile_path, 0);
}
$last_end_index = file_get_contents($indexfile_path);
$content = file_get_contents($log_path, false, null, $last_end_index);
if ($content === '') {
    echo json_encode([
        'status'    => FALSE,
        'log_path'  => $log_path,
        'message'   => "日志 $log_path 没有更新内容。",
    ]);
    die();
}
$last_end_index += strlen($content);
file_put_contents($indexfile_path, $last_end_index);

$lines = explode("\n", $content);
$countLines = count($lines);

$M = new PDOModel();
