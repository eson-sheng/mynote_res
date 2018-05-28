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
    if (isset($_SESSION['last_end_index'])) {//非第一次读取，接着上次读完的地方开始读取
        foreach ($_SESSION['last_end_index'] as $path => $index) {
            $content = file_get_contents($path, false, null, $index, $read_size);
            $encoding = mb_detect_encoding($content, "gb2312, utf-8", true);#转编码格式
            if ($encoding == 'EUC-CN') {#是gbk则转为utf-8
                $content = iconv("gbk", "utf-8", $content);
            }
            $content = htmlentities($content);#转html标签为实体
            $content = "$path<br/>" . $content;
            $data[$path] = $content;
            $content = file_get_contents($path);#日志全部内容
            $_SESSION['last_end_index'][$path] = $index + $read_size;//保存本次读取完结处
        }
    } else {//第一次读取，根据表单设置
        if (isset($_POST['show'])) {
            foreach ($_POST['show'] as $path => $value) {
                $start_index = 0;
                if ($from = $_POST['from'][$path]) {//从指定部分开始读取
                    $content = file_get_contents($path);#日志全部内容
                    $start_index = strpos($content, $from);#本次读取开始处
                    $content = file_get_contents($path, false, null, $start_index, $read_size);
                } elseif ($_POST['index'][$path]) {//从指定索引开始读取
                    $start_index = $_POST['index'][$path];
                    $content = file_get_contents($path, false, null, $start_index, $read_size);
                } else {//未设置起始读取，默认从头开始读取
                    $content = file_get_contents($path, false, null, 0, $read_size);
                }
                $_SESSION['last_end_index'][$path] = $start_index + $read_size;//保存本次读取完结处
                $encoding = mb_detect_encoding($content, "gb2312, utf-8", true);#转编码格式
                if ($encoding == 'EUC-CN') {#是gbk则转为utf-8
                    $content = iconv("gbk", "utf-8", $content);
                }
                $content = htmlentities($content);#转html标签为实体
                $content = "$path<br/>" . $content;
                $data[$path] = $content;
            }
        }
    }
    if ($data) {
        json(true, '指定日志的内容', $data);
    } else {
        json(false, '没有指定要读取的日志', '');
    }
}

/*
 * @describe 重置读取历史
 * */
function reset_history()
{
    unset($_SESSION['last_end_index']);
    json(true, '读取历史已重置', '');
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