<?php
$sign = 1;//第1个日志
include_once 'common.php';

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

    if (empty($data['time'])) {
        $M->execute("insert into `requests`(`num`,`uri`,`sessid`,`params`) ".
            "values({$data['rnum']},'{$data["REQUEST_URI"]}','{$data['PHPSESSID']}','{$data['params']}');");
    }else{
        $M->execute("update `requests` set `time`='{$data['time']}' where `num`={$data['rnum']};");
    }
}
echo '日志 ',$log_path,' 分析完毕。';