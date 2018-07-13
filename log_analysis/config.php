<?php

$log_paths = [
    './log.txt',
    './log2.txt'
];

$config_my_path = __DIR__ . '/config_my.php';
if (file_exists($config_my_path)) {
    require_once($config_my_path);
}
