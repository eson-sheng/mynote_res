<?php
ini_set('session.name', 'log_analysis');
session_start();
include_once 'pdo.php';
include_once "../config.php";
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
//    var_dump($data);

    if (empty($data['time'])) {
        $M->execute("insert into `requests`(`num`,`uri`,`sessid`,`params`) ".
            "values({$data['rnum']},'{$data["REQUEST_URI"]}','{$data['PHPSESSID']}','{$data['params']}');");
    }else{
        $M->execute("update `requests` set `time`='{$data['time']}' where `num`={$data['rnum']};");
    }
}
echo '程序执行完毕。';
var_dump($_SESSION);