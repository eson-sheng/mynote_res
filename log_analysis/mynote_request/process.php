<?php
include_once '../common.php';
$tbname = get_safe($_REQUEST, "tbname", "mynote_request");

for ($i = 0; $i < $countLines; $i++) {
    $line = $lines[$i];
    if (empty($line) || $line === "\r") {#空行
        continue;
    }
    $peices = explode('||', $line);
    if (count($peices) < 2) {
        CT_log("parse error 1: " . ($i + 1) . " line: " . $line);
        continue;
    }
//    var_dump($peices);die;
    $data = [];
    foreach ($peices as $peice) {
        $datum = explode(':', $peice);
        if(count($datum) < 2) {
            CT_log("parse error 2: " . ($i + 1) . " line: " . $line);
        }
        $data[trim($datum[0])] = trim($datum[1]);
    }
//    var_dump($data);die;

    if (empty($data['time'])) {
        $M->execute("insert into `$tbname`(`reqnum`,`uri`,`sessionid`,`params`,`req_time`) ".
            "values('{$data['rnum']}','{$data["REQUEST_URI"]}','{$data['PHPSESSID']}','{$data['params']}','{$data['req_time']}');");
    }else{
        $M->execute("update `$tbname` set `time`='{$data['time']}' where `reqnum`='{$data['rnum']}';");
    }
}

/*返回数据*/
echo json_encode([
    'status'    => TRUE,
    'log_path'  => $log_path,
    'message'   => "日志 {$log_path} 分析完毕。",
    "handled_lines" => $countLines,
]);

$M->execute("commit;");

CT_log("process finished, time=" . (get_time() - $begin) . "s");
