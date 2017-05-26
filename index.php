<?php

/**
 * 
 * noting Wait add
 * 
*/

define('KITE_START', microtime(true)); //记录启动时间
require __DIR__.'/core/autoload.php'; //加载核心自动载入文件
core\Kite::createWebApplication('core\Web')->run(); //启动web程序
define('KITE_END', microtime(true)); //记录终止时间
$runtime = number_format(KITE_END - KITE_START, 10);
echo "执行时间：".$runtime;
?>
