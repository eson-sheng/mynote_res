<?php
return array(
	//'配置项'=>'配置值'
    'DB_TYPE'=>'mysql',
    'DB_HOST'=>'127.0.0.1',
    'DB_NAME'=>'items_manag',
    'DB_USER'=>'root',
    'DB_PWD'=>'root123.',
    'DB_PORT'=>3306,
    'DB_PREFIX'=>'',//数据库表前缀
    'DB_CHARSET'=>'utf8',

    'TMPL_ENGINE_TYPE'=>'Smarty'//开启Smarty模板引擎
    //Smarty目录：/ThinkPHP/Library/Vendor/Smarty，可使用新版Smarty的libs内容将其覆盖。默认旧版本Smarty不能使用入口文件定义的常量。
    //Smarty配置：/ThinkPHP/Library/Think/Template/Driver/Smarty.class.php
);