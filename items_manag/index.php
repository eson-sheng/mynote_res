<?php
// 应用入口文件
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');// 检测PHP环境
define('APP_DEBUG',True);// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_PATH','./Application/');// 定义应用目录
//====================================================
#define('BIND_MODULE','Admin');//绑定入口文件到Admin模块访问，首次运行生成目录。
define('DS', DIRECTORY_SEPARATOR);

if(dirname($_SERVER['SCRIPT_NAME'])==DS)//项目在网站根目录下
    define('PUB','/Public/');//供浏览器访问（网站根目录相对路径）
else//项目在网站根目录下的一个目录下
    define('PUB',dirname($_SERVER['SCRIPT_NAME']).'/Public/');

define('UPLOAD',dirname(APP_PATH).DS.'Public'.DS.'upload'.DS);//供服务器访问（文件系统绝对路径）
define('IMG',dirname(APP_PATH).DS.'Public'.DS.'img'.DS);//供服务器访问（画验证码用）


define('IP','127.0.0.1');#网站根目录的地址
#//====================================================
//路径测试
/*echo _PUBLIC;echo '<br />';
echo(realpath('.'));echo '<br />';//“.”是从本地磁盘根目录计算到网站根目录。
echo(realpath('./Application/'));echo '<br />';
echo dirname('./Application/');echo '<br />';
echo realpath(dirname('./Application/'));die;
#试验：<a href="<?=UPLOAD??>" target="_blank">Link</a>，点进去看地址栏可知，在浏览器内使用此常量会得出错误结果。/index.php/Home/Index/Public/Upload/*/
require './ThinkPHP/ThinkPHP.php';// 引入ThinkPHP入口文件
#默认控制器与操作名的设置在 ./ThinkPHP/Conf/convention.php

// 亲^_^ 后面不需要任何代码了 就是如此简单

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------