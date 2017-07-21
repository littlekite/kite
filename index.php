<?php
/**
 * ╥━━━━━━━━╭━━╮━━┳
 * ╢╭╮╭━━━━━┫┃▋▋━▅┣ 
 * ╢┃╰┫┈┈┈┈┈┃┃┈┈╰┫┣ 
 * ╢╰━┫┈┈┈┈┈╰╯╰┳━╯┣ 
 * ╢┊┊┃┏┳┳━━┓┏┳┫┊┊┣ 
 * ╨━━┗┛┗┛━━┗┛┗┛━━┻
 */

define('KITE_DEBUG', true); //调试按钮
define('DS', DIRECTORY_SEPARATOR);
define('APP_PATH', __DIR__ .DS);
define('RUNTIME_PATH', APP_PATH . 'runtime' . DS);
define('CACHE_PATH', RUNTIME_PATH . 'cache' . DS);
if(KITE_DEBUG){
    define('KITE_START', microtime(true)); //记录启动时间 debug
    define('SERVER_START_MEM', memory_get_usage()); //记录内存使用debug
    define('SERVER_START_TIME', microtime(true));
    define('LOG_PATH', RUNTIME_PATH . '/log/common' .DS);
    error_reporting(E_ALL); //报告所有错误
    ini_set("display_errors", 1); //显示错误
}
require __DIR__.'/core/Autoload.php'; //加载核心自动载入文件
require __DIR__.'/core/Common.php';//加载功能函数文件
core\Kite::createWebApplication('core\Web')->run(); //启动web程序
define('KITE_END', microtime(true)); //记录终止时间
$runtime = number_format(KITE_END - KITE_START, 10);

if(KITE_DEBUG){
    core\Log::save(); //如果调试状态 记录日志信息
}
//debug区域
/*
$memory_use = number_format((memory_get_usage() - SERVER_START_MEM) / 1024, 2);
echo   '内存消耗：' . $memory_use . 'kb'."<br/>";
$included_files = get_included_files();
foreach ($included_files as $filename) {
     echo "$filename\n";
}

echo "执行时间：".$runtime;
*/
?>
