<?php
$ct_log_path = __DIR__ . "/ana_logs.txt";

include_once 'pdo.php';
include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/../common.php";

$M = new PDOModel();
$begin = get_time();

$log_path = get_safe($_REQUEST, "logpath", "logs.txt");
if(is_dir($log_path)){
    $log_path = $log_path . '/' . date('Ymd') . '.log';
}

/*查询数据库得到文件行号*/
$sql = "
SELECT `last_end_index` FROM `mynote_indexfile` WHERE indexfile_path = '{$log_path}' ;
";
$pdo = $M->index();
$query = $pdo->prepare($sql);
$query->execute(); 
$rs = $query->fetch();
if ($rs) {
    $last_end_index = $rs['last_end_index'];
} else {
    $last_end_index = 0;
}

if (!is_file($log_path)) {
    echo json_encode([
        'status'    => FALSE,
        'log_path'  => $log_path,
        'message'   => "日志 $log_path 不存在。",
    ]);
}

$content = file_get_contents($log_path, false, null, $last_end_index);
$lines = [];
if ($content !== '') {
    $lines = explode("\n", $content);
    /*修改数据库数据，修改文件行号*/
    $last_end_index += strlen($content);
    $sql = "
INSERT INTO mynote_indexfile
    ( last_end_index, indexfile_path )
VALUES 
    ( '{$last_end_index}','{$log_path}' )
ON DUPLICATE KEY UPDATE
    last_end_index = '{$last_end_index}' ,
    indexfile_path = '{$log_path}' 
";
    $M->execute($sql);
}
$countLines = count($lines);
