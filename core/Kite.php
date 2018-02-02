<?php
namespace core;
class Kite{
    public static function run(){
         $route = Route::check();//路由检测
         $config  = require 'Config.php';
         if (in_array($route[0], $config['module_list'])){
            if (count($route) == 2) { //默认home模块
                $controller = 'project\\'.$route[0].'\\'.$route[1];
                $action = $route[1]; 
            } elseif(count($route) == 3){
                $controller = 'project\\'. $route[0].'\\'. $route[1].'\\'.$route[2]; 
                $action = $route[2];
            } 
         } else { //404
            $controller = 'project\home\index\error'; 
            $action = 'error';
         }
         $class = new $controller();
         $class->$action();
    }
}
?>