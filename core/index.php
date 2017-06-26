<?php
/**
 **********************
 * try angin now
 **********************
 */
define('KITE_START', microtime(true)); //记录启动时间
define('KITE_DEBUG', true); //调试按钮
define('DS', DIRECTORY_SEPARATOR);
define('APP_PATH', __DIR__ .DS);
if(KITE_DEBUG){
    error_reporting(E_ALL); //报告所有错误
    ini_set("display_errors", 1); //显示错误
}
require __DIR__.'/core/Autoload.php'; //加载核心自动载入文件
require __DIR__.'/core/Common.php';//加载功能函数文件
core\Kite::createWebApplication('core\Web')->run(); //启动web程序
define('KITE_END', microtime(true)); //记录终止时间
$runtime = number_format(KITE_END - KITE_START, 10);
//echo "执行时间：".$runtime;
?>
