<?php
require_once "../common.php";
header("Content-Type: text/html; charset=utf-8");
$result = [];
if (isset($_POST["msg"])) {
//    echo $_POST["msg"];
    date_default_timezone_set("Asia/Shanghai");
    CT_log("--------------" . date("m-d h:i:s") . "\n" . $_POST["msg"] . "\n", "msgs.txt");
    $result["url"] = $_SERVER["HTTP_ORIGIN"] . dirname($_SERVER["REQUEST_URI"]) . "/msgs.txt";
    $result["status"] = "success";
} else {
    echo "没有POST msg参数!";
}

echo json_encode($result);
