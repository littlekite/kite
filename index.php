<?php

/**
 * 
 * noting Wait add
 * 
*/

define('KITE_START', microtime(true)); //记录启动赶时间
require __DIR__.'/core/autoload.php'; //加载核心自动载入文件
$config = __DIR__.'/core/config/main.php'; //加载核心配置文件
App::createWebApplication($config)->run(); //启动web程序

?>