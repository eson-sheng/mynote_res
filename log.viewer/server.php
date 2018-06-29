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
    $err_info = '';

    if (isset($_POST['show']) && isset($_SESSION['last_end_index'])) {
        foreach ($_POST['show'] as $path => $on) {
            if(!file_exists($path)){
                continue;#文件不存在，跳过
            }
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

            if ($record_length2 === 0 && $record_length1 !== 0) {//截断了汉字出现乱码情况
                $err_info = '索引值截断了汉字，请调整索引值后再试';
            }
            $content = "$path\n" . $content;#首行插入日志路径

            $data[$path] = $content;
        }
    }else{
        $err_info='未设置';
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
 * @describe 提交设置
 * */
function do_config()
{
    if(isset($_POST['fromtail'])){#设置从末尾开始读
        foreach ($_POST['fromtail'] as $path){
            $_SESSION['last_end_index'][$path] = filesize($path);
        }
    }else{#设置从指定的地方开始读
        foreach ($_POST['show'] as $path=>$on){
            $from_text = $_POST['from'][$path];
            $from_index = $_POST['index'][$path];
            if($from_text){#设置了起始部分
                $content = file_get_contents($path);
                $_SESSION['last_end_index'][$path] = strpos($content, $from_text);
            }elseif($from_index){#设置了起始索引
                if ($from_index < 0) {//索引为负值
                    $from_index = filesize($path) + $from_index;
                }
                $_SESSION['last_end_index'][$path] = $from_index;
            }else{#都没有设置，默认从头开始
                $_SESSION['last_end_index'][$path] = 0;
            }
        }
    }
    json(true, '设置成功', '');
}
/*
 * @describe 获取读取进度
 * */
function getPercentages()
{
    $percentages=[];
    foreach ($_SESSION['last_end_index'] as $path=>$index){
        $filesize=filesize($path);
        $percentages[$path]=$index/$filesize;
    }
    json(true,'读取进度',$percentages);
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