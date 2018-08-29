<?php
$g_config = [];
$g_config["host"] = "localhost";
$g_config["username"] = "root";
$g_config["pwd"] = "root";
$g_config["port"] = "3306";
$g_config["logana_dbname"] = "mynote";

$config_my_path = __DIR__ . '/config_my.php';
if (file_exists($config_my_path)) {
    require_once($config_my_path);
}
