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
    if (empty($line)) {#空行
        continue;
    }
    $peices = explode('||', $line);

    $ip = trim(substr($peices[0], strpos($peices[0], ':') + 1));
    $sessid = trim(substr($peices[1], strpos($peices[1], ':') + 1));
    $time = trim(substr($peices[2], strpos($peices[2], ':') + 1));
    $request_time = trim(substr($peices[3], strpos($peices[3], ':') + 1));
    $ur_time = trim(substr($peices[4], strpos($peices[4], ':') + 1));
    $request = trim(substr($peices[5], strpos($peices[5], ':') + 1));
    $status = trim(substr($peices[6], strpos($peices[6], ':') + 1));
    $bytes_sent = trim(substr($peices[7], strpos($peices[7], ':') + 1));
    $ua = trim(substr($peices[8], strpos($peices[8], ':') + 1));
    $forward = trim(substr($peices[9], strpos($peices[9], ':') + 1));

     $a=$M->execute("insert into `requests2`(`ip`,`sessid`,`time`,`request_time`,`ur_time`,`request`,`status`,`bytes_sent`,`ua`,`forward`) values('$ip','$sessid','$time','$request_time','$ur_time',$request,'$status','$bytes_sent',$ua,$forward);");
}
echo '程序执行完毕。';
var_dump($_SESSION);