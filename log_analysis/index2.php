<?php
ini_set('session.name', 'log_analysis');
session_start();
include_once 'pdo.php';
include_once "../config.php";
$M = new PDOModel();
$log_path = './logs2.txt';

if (empty($_SESSION['last_end_index2'])) {
    $_SESSION['last_end_index2'] = 0;
}
$last_end_index = $_SESSION['last_end_index2'];
$content = file_get_contents($log_path, false, null, $last_end_index);
$last_end_index += strlen($content);
$_SESSION['last_end_index2'] = $last_end_index;

$lines = explode("\n", $content);
$countLines = count($lines);
for ($i = 0; $i < $countLines; $i++) {
    $line = $lines[$i];
    if (empty($line) || $line === "\r") {#空行
        continue;
    }
    $peices = explode('||', $line);
//    var_dump($peices);die;
    $data = [];
    foreach ($peices as $peice) {
        $datum = explode(':', $peice);
        $data[trim($datum[0])] = trim($datum[1]);
    }
//    var_dump($data);die;

    $a = $M->execute("insert into `requests2`(`ip`,`sessid`,`time`,`request_time`,`ur_time`,`request`,`status`,`bytes_sent`,`ua`,`forward`) values('{$data['IP']}','{$data['PHPSESSID']}','{$data['time']}','{$data['request_time']}','{$data['ur_time']}',{$data['request']},'{$data['status']}','{$data['bytes_sent']}',{$data['UA']},{$data['forward']});");
}
echo '程序执行完毕。';
var_dump($_SESSION);