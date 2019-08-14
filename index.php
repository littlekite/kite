<?php
/**
 * ╥━━━━━━━━╭━━╮━━┳
 * ╢╭╮╭━━━━━┫┃▋▋━▅┣ 
 * ╢┃╰┫┈┈┈┈┈┃┃┈┈╰┫┣ 
 * ╢╰━┫┈┈┈┈┈╰╯╰┳━╯┣ 
 * ╢┊┊┃┏┳┳━━┓┏┳┫┊┊┣ 
 * ╨━━┗┛┗┛━━┗┛┗┛━━┻
 * author yankuan
 * link https://github.com/littlekite/kite
 * email 1026431088@qq.com
 */
define('KITE_DEBUG', true); //调试按钮
define('DS', DIRECTORY_SEPARATOR);
define('APP_PATH', __DIR__ . DS);
define('RUNTIME_PATH', APP_PATH . 'runtime' . DS);
define('CACHE_PATH', RUNTIME_PATH . 'cache' . DS);
if (KITE_DEBUG) {
    define('SERVER_START_MEM', memory_get_usage()); //记录内存使用debug
    define('SERVER_START_TIME', microtime(true));
    define('LOG_PATH', RUNTIME_PATH . '/log/common' .DS);
    error_reporting(E_ALL); //报告所有错误
    ini_set("display_errors", 1); //显示错误
}
require __DIR__.'/core/Autoload.php'; //加载核心自动载入文件
require __DIR__.'/core/Common.php';//加载功能函数文件
core\Kite::run(); //启动web程序
if (KITE_DEBUG) {
    core\Log::save(); //如果调试状态 记录日志信息
}
?>
