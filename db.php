<?php    
    define('APP_DEBUG', true);
    define('SERVER_START_TIME', microtime(true));
    define('SERVER_START_MEM', memory_get_usage());
    define('DS', DIRECTORY_SEPARATOR);
    define('SERVER_PATH', __DIR__ .DS);
    define('RUNTIME_PATH', SERVER_PATH . 'runtime' . DS);
    define('CACHE_PATH', RUNTIME_PATH . 'cache' . DS);
    define('LOG_PATH', RUNTIME_PATH . 'log' .DS);
    require __DIR__.'/core/autoload.php'; //加载核心自动载入文件
    require __DIR__.'/core/Common.php';
    $post = input();
    $m = $post['m'];
    $method_list = require 'core/enum/Method.php';          
    if (!empty($m)&&!empty($method_list[$m])) {
        $method = $method_list[$m];
        $table = $method['t'];
        $function = $method['a'];
        require 'model/'.$table.'.php';
        $class = 'model\\'.$table;
        $model = new $class();
        echo $model->$function();   
    }