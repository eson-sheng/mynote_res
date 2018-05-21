<?php
ini_set('max_execution_time', '120');
$min = 0;
$show_num = 0;
if (!empty($_GET['min'])) $min = $_GET['min'];
if (isset($_GET['show_num'])) $show_num = $_GET['show_num'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>统计IP个数</title>
</head>
<body>
<form action="" method="get">
    <dl>
        <dt>是否显示IP地址出现次数</dt>
        <dd>
            <input type="checkbox" name="show_num" checked="checked"/>
        </dd>
        <dt>IP地址出现次数最小值（统计结果将将入filter.txt）</dt>
        <dd>
            <input type="number" name="min" min="0" value="2000"/>
        </dd>
    </dl>
    <input type="submit" value="开始统计"/>
</form>
<hr/>
<?php

// 获取当前系统时间，返回float格式，单位：秒
function get_time() {
    date_default_timezone_set('Asia/Shanghai');
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

$filter = [];
$res = fopen('./filter.txt', 'r');
while (!feof($res)) {
    $line = fgets($res);
    $line = str_replace("\r\n", "", $line);
    $filter[] = $line;
}
$filter0 = $filter;
##############################
$IPs = [];
$res = fopen('./www_access.log', 'r');
$line_num = 1;
$begin = get_time();
$content = file_get_contents('./www_access.log');
/**/
while (!feof($res)) {
    $line = fgets($res);
    $index1 = strpos($line, '[') + 1;
    $index2 = strpos($line, ']');
    $target = substr($line, $index1, $index2 - $index1);

    if ($target) {//IP地址不为空
        if (!in_array($target, $filter0)) {//不存在于$filter0
            if (array_key_exists($target, $IPs)) {//存在于$IPs
                $IPs[$target]++;
            } else {//不存在于$IPs
                $IPs[$target] = 1;
            }
        }

        if (!in_array($target, $filter)) {//不存在于$filter
            if ($IPs[$target] >= $min) {//次数不小于最小次数，加入filter.txt
                $filter[] = $target;//加入$filter
                file_put_contents('./filter.txt', $target . "\r\n", FILE_APPEND);
            }
        }
    }

}

echo "耗时：".(get_time() - $begin) . " s<br/>";

fclose($res);
arsort($IPs);
$count = 0;
foreach ($IPs as $ip => $num) {
    if ($show_num) {//显示次数
        if ($num >= $min) {
            echo "$ip --> $num<br/>";
            $count++;
        }
    } else {//不显示次数
        if ($num >= $min) {
            echo "$ip<br/>";
            $count++;
        }
    }
}
echo '总数：', $count, '<br/>';

?>
</body>
</html>