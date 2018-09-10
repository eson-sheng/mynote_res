<?php
include_once '../common.php';
$tbname = get_safe($_REQUEST, "tbname", "mynote_log");
$logger = pathinfo(get_safe($_REQUEST,"logpath"),PATHINFO_BASENAME);
$line_peices = [];
for ($i = 0; $i < $countLines; $i++) {
    $line = $lines[$i];
    if (empty($line) || $line === "\r") {#空行
        continue;
    }
    $peices = explode('-||-', $line);
    if (strpos($line,'-||-') !== false) { //是数据首行
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

            $M->execute("insert into `$tbname`(`datetime`,`level`,`class`,`filename`,`reqnum`,`message`,`logger`) " .
                "values('{$line_peices[0]}',{$line_peices[1]},'{$line_peices[2]}','{$line_peices[3]}','".trim($line_peices[4])."','".addslashes($line_peices[5])."','{$logger}');");

            $line_peices = [];
        }

        $line_peices = $peices;

    } else {//非数据首行，插入到最后一个字段
        $line_peices[5] .= "\\n {$peices[0]}";
    }
}
if (count($line_peices) > 5) {
    $M->execute("insert into `$tbname`(`datetime`,`level`,`class`,`filename`,`reqnum`,`message`,`logger`) " .
        "values('{$line_peices[0]}',{$line_peices[1]},'{$line_peices[2]}','{$line_peices[3]}','".trim($line_peices[4])."','".addslashes($line_peices[5])."','{$logger}');");//插入最后一行数据
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
