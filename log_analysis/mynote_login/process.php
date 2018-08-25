<?php
include_once '../common.php';
$tbname = get_safe($_REQUEST, "tbname", "mynote_login");

$line_peices = [];
for ($i = 0; $i < $countLines; $i++) {
    $line = $lines[$i];
    if (empty($line) || $line === "\r") {#空行
        continue;
    }
    $peices = explode('', $line);
    if (strpos($line, '') !== false) { //是数据首行
        switch (trim($peices[1])) {
            case 'DEBUG':
                $peices[1] = 8;
                break;
            case 'INFO':
                $peices[1] = 7;
                break;
            case 'NOTICE':
                $peices[1] = 6;
                break;
            case 'WARNING':
                $peices[1] = 5;
                break;
            case 'ERROR':
                $peices[1] = 4;
                break;
            case 'CRITICAL':
                $peices[1] = 3;
                break;
            case 'ALERT':
                $peices[1] = 2;
                break;
            case 'EMERGENCY':
                $peices[1] = 1;
                break;
        }
        if ($i !== 0) {
            $arr = explode(',', $line_peices[6]);
            $nickname = $arr[0];
            $sessionid = $arr[1];
            $status = $arr[2];

            $M->execute("insert into `$tbname`(`datetime`,`reqid`,`nickname`,`sessionid`,`status`) " .
                "values('{$line_peices[0]}',{$line_peices[5]},'$nickname','$sessionid',$status);");

            $line_peices = [];
        }

        $line_peices = $peices;

    } else {//非数据首行，插入到最后一个字段
        $line_peices[6] .= $peices[0];
    }
}
$M->execute("insert into `$tbname`(`datetime`,`reqid`,`nickname`,`sessionid`,`status`) " .
    "values('{$line_peices[0]}',{$line_peices[5]},'$nickname','$sessionid',$status);");
echo '日志 ', $log_path, ' 分析完毕。';