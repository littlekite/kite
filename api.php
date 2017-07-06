<?php    
    define('KITE_DEBUG', true);
    define('SERVER_START_TIME', microtime(true));
    define('SERVER_START_MEM', memory_get_usage());
    define('DS', DIRECTORY_SEPARATOR);
    define('SERVER_PATH', __DIR__ .DS);
    define('RUNTIME_PATH', SERVER_PATH . 'runtime' . DS);
    define('CACHE_PATH', RUNTIME_PATH . 'cache' . DS);
    define('LOG_PATH', RUNTIME_PATH . 'log' .DS);
    require __DIR__.'/core/Autoload.php'; //加载核心自动载入文件
    require __DIR__.'/core/Common.php';
    if(KITE_DEBUG){
        error_reporting(E_ALL); //报告所有错误
        ini_set("display_errors", 1); //显示错误
    }
    $post = input();
    if(!empty($post)){
        $d_string = json_encode($post); 
    } else {
        $d_string = "have request but no param";  
    }
    core\Db::execute("INSERT INTO `k_getdata` (`id`, `data`) VALUES (null, ?)",[$d_string]); 
    $m = $post['m'];
    $method_list = require 'core/enum/Method.php';        
    if (!empty($m)&&!empty($method_list[$m])) {
        $method = $method_list[$m];
        $table = $method['t'];
        $function = $method['a'];
        require 'core/api/'.$table.'.php';
        $class = '\\core\\api\\'.$table;
        $model = new $class();
        echo $model->$function();   
    }