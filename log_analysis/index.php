<?php
ini_set('session.name', 'log_analysis');
session_start();
include_once 'pdo.php';
$M = new PDOModel();
$log_path = './logs.txt';

if (empty($_SESSION['last_end_index'])) {
    $_SESSION['last_end_index'] = 0;
}
$last_end_index = $_SESSION['last_end_index'];
$content = file_get_contents($log_path, false, null, $last_end_index);
$last_end_index += strlen($content);
$_SESSION['last_end_index'] = $last_end_index;

$lines = explode("\n", $content);
$countLines = count($lines);
for ($i = 0; $i < $countLines; $i++) {
    $line = $lines[$i];
    if (empty($line)) {#空行
        continue;
    }
    $peices = explode('||', $line);
//    var_dump($peices);

    $uri = trim(substr($peices[0], strpos($peices[0], ':') + 1));
    $sessid = trim(substr($peices[1], strpos($peices[1], ':') + 1));
    $num = trim(substr($peices[2], strpos($peices[2], ':') + 1));
    $params = trim(substr($peices[3], strpos($peices[3], ':') + 1));
    $time = null;
    if (strpos($peices[3], 'params') === false) {
        $time = $params;
    }
    if($time){
        $M->execute("update `requests` set `time`='$time' where `num`=$num;");
    }else{
        $M->execute("insert into `requests`(`num`,`uri`,`sessid`,`params`) values($num,'$uri','$sessid','$params');");
    }

}
