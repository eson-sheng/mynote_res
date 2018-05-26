<?php
ini_set('session.name', 'logviewer');
session_start();

$_GET['op']();

/*
 * @describe 接口：获取指定日志的内容
 * */
function get_logs_content()
{
    $data = [];
    if (isset($_SESSION['last_end_index'])) {//非第一次读取，接着上次读完的地方开始读取
        foreach ($_SESSION['last_end_index'] as $path => $index) {
            $content = file_get_contents($path, false, null, $index);
            $content = htmlentities($content);#转html标签为实体
            $content = "$path<br/>" . $content;
            $data[$path] = $content;
            $content = file_get_contents($path);#日志全部内容
            $_SESSION['last_end_index'][$path] = strlen($content);#本次读取结束处
        }
    } else {//第一次读取，根据表单设置
        if (isset($_POST['show'])) {
            foreach ($_POST['show'] as $path => $value) {
                $_SESSION['last_end_index'][$path] = filesize($path);#本次读取结束处
                if ($from = $_POST['from'][$path]) {//从指定部分开始读取
                    $content = file_get_contents($path);#日志全部内容
                    $start_index = strpos($content, $from);#本次读取开始处
                    $content = file_get_contents($path, false, null, $start_index);
                } elseif ($start_index = $_POST['index'][$path]) {//从指定索引开始读取
                    $content = file_get_contents($path, false, null, $start_index);
                    #$content = mb_substr($content, 2, strlen($content));
                } else {//未设置起始读取，默认读取全部
                    $content = file_get_contents($path);
                }
                $content = htmlentities($content);#转html标签为实体
                $content = "$path<br/>" . $content;
                $encoding = mb_detect_encoding($content, "gb2312, utf-8", true);#转编码格式
                if ($encoding == 'EUC-CN') {#gbk
                    $content = iconv("gbk", "utf-8", $content);#转为utf-8
                }
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