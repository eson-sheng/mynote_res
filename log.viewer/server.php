<?php
ini_set('session.name', 'logviewer');
session_start();

require_once './logs.php';

$_GET['op']();

/*
 * @describe 接口：获取指定日志的内容
 * */
function get_logs_content()
{
    global $read_size;
    if (empty($read_size)) {
        $read_size = 500000;//默认配置：每次读取的长度
    }
    $data = [];

    if (isset($_POST['show']) && isset($_SESSION['last_end_index'])) {
        foreach ($_POST['show'] as $path => $on) {
            $start_index = $_SESSION['last_end_index'][$path];
            $content = file_get_contents($path, false, null, $start_index, $read_size);
            $_SESSION['last_end_index'][$path] = $start_index + strlen($content);

            $encoding = mb_detect_encoding($content, "gb2312, utf-8", true);#转编码格式
            if ($encoding == 'EUC-CN') {#是gbk则转为utf-8
                $content = iconv("gbk", "utf-8", $content);
            }

            $record_length1 = strlen($content);//记录内容的长度，用于检查
            $content = htmlentities($content);#转html标签为实体
            $record_length2 = strlen($content);//第二次记录内容的长度，用于检查
            $err_info = '';
            if ($record_length2 === 0 && $record_length1 !== 0) {//截断了汉字出现乱码情况
                $err_info = '索引值截断了汉字，请调整索引值后再试';
            }
            $content = "$path\n" . $content;#首行插入日志路径

            $data[$path] = $content;
        }
    }

    if ($data && !$err_info) {
        json(true, '指定日志的内容', $data);
    } elseif($err_info) {
        json(false, $err_info, '');
    }else{
        json(false, '尚未设置', '');
    }
}

/*
 * @describe 设置全部从当前末尾开始读
 * */
function set_to_end()
{
    foreach ($_SESSION['last_end_index'] as $path => &$index) {
        $index = filesize($path);
    }
    json(true, '所有日志将从当前末尾开始读', '');
}

/*
 * @describe 提交读取设置
 * */
function do_config()
{
    if (isset($_POST['show'])) {
        foreach ($_POST['from'] as $path => $from) {
            $index = $_POST['index'][$path];
            if ($from) {//设置了起始部分
                $content = file_get_contents($path);
                $_SESSION['last_end_index'][$path] = strpos($content, $from);
            } elseif ($index) {//设置了起始索引
                if ($index < 0) {//索引为负值
                    $index = filesize($path) + $index;
                }
                $_SESSION['last_end_index'][$path] = $index ? $index : 0;
            } else {//都没有设置，默认从头开始读
                $_SESSION['last_end_index'][$path] = 0;
            }
        }
    }
    json(true, '设置成功', '');
}

/*
 * @describe 输出json数据
 * */
function json($isOk, $message, $data)
{
    $result = [
        'result' => $isOk ? 'success' : 'error',
        'message' => $message,
        'data' => $data
    ];
    echo json_encode($result);
}