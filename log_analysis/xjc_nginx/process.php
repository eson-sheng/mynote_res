<?php
include_once '../common.php';

for ($i = 0; $i < $countLines; $i++) {
    $line = $lines[$i];
    if (empty($line) || $line === "\r") {#空行
        continue;
    }
    $peices = explode('||', $line);
//    var_dump($peices);die;
    $data = [];
    foreach ($peices as $peice) {
        $datum = explode(':', $peice,2);
        if(trim($datum[0])==='time'){
            $data[trim($datum[0])] = date('Y-m-d H:i:s',strtotime($datum[1]));
        }else{
            $data[trim($datum[0])] = trim($datum[1]);
        }
    }
//    var_dump($data);die;

    $result = $M->execute("insert into `xjc_nginx`(`ip`,`sessid`,`time`,`request_time`,`ur_time`,`request`,`status`,`bytes_sent`,`ua`,`forward`) values('{$data['IP']}','{$data['PHPSESSID']}','{$data['time']}','{$data['request_time']}','{$data['ur_time']}',{$data['request']},'{$data['status']}','{$data['bytes_sent']}',{$data['UA']},{$data['forward']});");
}
echo '日志 ',$log_path,' 分析完毕。';