<?php
ini_set('max_execution_time', '120');

$flag = false;//是否开始工作
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $flag = true;
    $min = 0;
    $show_num = 0;
    if (!empty($_POST['min'])) {
        $min = $_POST['min'];
    }
    if (isset($_POST['show_num'])) {
        $show_num = $_POST['show_num'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>统计IP个数</title>
</head>
<body>
<form action="" method="post">
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
function get_time()
{
    date_default_timezone_set('Asia/Shanghai');
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

if ($flag) {
    #读取filter.txt
    $begin = get_time();#开始计时
    $filter = [];
    $res = fopen('./filter.txt', 'r');
    while (!feof($res)) {
        $line = fgets($res);
        $line = str_replace("\r\n", "", $line);
        $filter[] = $line;
    }
    $filter0 = $filter;
    echo "读取filter.txt耗时：" . (get_time() - $begin) . " (s)<br/>";
    #+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    $begin = get_time();#开始计时
    $IPs = [];
    $res = fopen('./www_access.log', 'r');
    $content = file_get_contents('./www_access.log');

    while (!feof($res)) {
        $line = fgets($res);
        $index1 = strpos($line, '[') + 1;
        $index2 = strpos($line, ']');
        $ip = substr($line, $index1, $index2 - $index1);

        if ($ip) {//IP地址不为空
            if (!in_array($ip, $filter0)) {//不存在于$filter0
                if (array_key_exists($ip, $IPs)) {//存在于$IPs
                    $IPs[$ip]++;
                } else {//不存在于$IPs
                    $IPs[$ip] = 1;
                }
            }

            if (!in_array($ip, $filter)) {//不存在于$filter（尚未加入filter.txt）
                if ($IPs[$ip] >= $min) {//符合条件，加入filter.txt
                    $filter[] = $ip;//加入$filter
                    file_put_contents('./filter.txt', $ip . "\r\n", FILE_APPEND);
                }
            }
        }

    }

    echo "读取www_access.txt耗时：" . (get_time() - $begin) . " (s)<br/>";
    $begin = get_time();#开始计时

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
    echo "输出结果耗时：" . (get_time() - $begin) . " (s)<br/>";
    echo '符合要求的IP地址个数：', $count, '<br/>';
}
?>
</body>
</html>