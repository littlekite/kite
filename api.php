<?php    
    define('KITE_DEBUG', true);
    define('VISIT_RECORD', true); //行为记录
    define('SERVER_START_TIME', microtime(true));
    define('SERVER_START_MEM', memory_get_usage());
    define('DS', DIRECTORY_SEPARATOR);
    define('SERVER_PATH', __DIR__ .DS);
    define('RUNTIME_PATH', SERVER_PATH . 'runtime' . DS);
    define('CACHE_PATH', RUNTIME_PATH . 'cache' . DS);
    define('LOG_PATH', RUNTIME_PATH . '/log/api' .DS);
    require __DIR__.'/core/Autoload.php';
    require __DIR__.'/core/Common.php';
    $post = input();
    if (KITE_DEBUG) {
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        if (VISIT_RECORD) {
            if (!empty($post)) {
                $d_string = json_encode($post); 
            } else {
                $d_string = "have request but no params";  
            }
            core\Db::execute("INSERT INTO `k_getdata` (`id`, `data`, `data_url`) VALUES (null, ?, ?)", [$d_string, $_SERVER['REQUEST_URI']]); //记录每一个请求信息
            $id = core\Db::getId(); //获取请求记录的ID
        }
    }
    $m = $post['m'];
    $method_list = require 'project/api/static/Method.php';        
    if (!empty($m) && !empty($method_list[$m])) {
        $method = $method_list[$m];
        $table = $method['t'];
        $function = $method['a'];
        require 'project/api/'.$table.'.php';
        $class = '\\project\\api\\'.$table;
        $model = new $class();
        echo $model->$function();  
        if (KITE_DEBUG) {
            core\Log::save(); //如果调试状态 记录日志信息
            if (VISIT_RECORD) { //如果开启了行为记录
                $log = core\Log::getRecord('return');
                core\Db::execute("UPDATE `k_getdata` SET `response_data`=? WHERE (`id`=?)", [$log, $id]); //记录返回结果 
            }
        }   
    }