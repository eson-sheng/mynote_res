<?php

$ct_log_path = __DIR__ . "/ana_all.log";
require "../common.php";
$begin = get_time();
$items = [];

// please config $items in runner.my.php !
//$items = [
//        [
//            "api" => "mynote_login/process.php",
//            "path" => "E:/mynote/basic/runtime/seaslog/login"
//        ]
//    ];
$base_url = "http://dev.rongyipiao.com:82/log_analysis/";

$path_my = __DIR__ . "/runner.my.php";
if (is_file($path_my)) {
    require_once $path_my;
}

$res = array();
foreach ($items as $item) {
    $params["logpath"] = $item["path"];
    if(isset($item["tbname"])) {
        $params["tbname"] = $item["tbname"];
    }

    $url = $base_url . $item["api"] . "?" . http_build_query($params);
    $result = shell_exec("curl $url");
    CT_log("----url: " . $url . "\n" . $result);
    /*返回数据*/
    $res[] = array(
        'url' => $url,
        'res' => json_decode($result),
    );
}

echo json_encode($res);
CT_log("runner done, time: ". (get_time() - $begin) . "s");
