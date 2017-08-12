<?php    
    define('KITE_DEBUG', true);
    define('SERVER_START_TIME', microtime(true));
    define('SERVER_START_MEM', memory_get_usage());
    define('DS', DIRECTORY_SEPARATOR);
    define('SERVER_PATH', __DIR__ .DS);
    define('RUNTIME_PATH', SERVER_PATH . 'runtime' . DS);
    define('CACHE_PATH', RUNTIME_PATH . 'cache' . DS);
    define('LOG_PATH', RUNTIME_PATH . '/log/api' .DS);
    require __DIR__.'/core/Autoload.php'; //加载核心自动载入文件
    require __DIR__.'/core/Common.php';
    $post = input();
    if(KITE_DEBUG){
        error_reporting(E_ALL); //报告所有错误
        ini_set("display_errors", 1); //显示错误
        if (!empty($post)) {
            $d_string = json_encode($post); 
        } else {
            $d_string = "have request but no param";  
        }
        core\Db::execute("INSERT INTO `k_getdata` (`id`, `data`, `data_url`) VALUES (null, ?, ?)", [$d_string, $_SERVER['REQUEST_URI']]); //记录每一个请求信息
        $id = core\Db::getId(); 
    }
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
        if(KITE_DEBUG){
            core\Log::save(); //如果调试状态 记录日志信息  
            $log = core\Log::getRecord('return');
            core\Db::execute("UPDATE `k_getdata` SET `response_data`=? WHERE (`id`=?)", [$log, $id]); //记录返回结果    
        } 
    }