<?php
//require "../common.php";
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
    /*返回数据*/
    $res[] = array(
        'url' => $url,
        'res' => json_decode(shell_exec("curl $url")),
    );
}

echo json_encode($res);
