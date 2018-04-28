<?php

include_once 'pdo.php';

if (!empty($_GET)) {
    $function = $_GET['callback'];
    $data = $_GET['data'];
    $keyword = $_GET['keyword'];

    $data_ = json_decode($data, true);

    $model = new Model('localhost', 'crawler');

    $error_log_filename = 'error_log.txt';
    file_put_contents($error_log_filename, '');# 初始化错误日志

    foreach ($data_ as $page_num => $page_data) {
        foreach ($page_data as $each_link) {
            $result = $model->save($keyword, $page_num, strip_tags($each_link), date('Y-m-d'));
            if (!$result) {
                file_put_contents($error_log_filename, "keyword: $keyword \n page_num: $page_num \n link: $each_link \n date: " . date('Y-m-d'), FILE_APPEND);
            }
        }
    }

    echo $function . '(1)';//调用前端的回调函数
}

