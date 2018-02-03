<?php
namespace core;
class Kite{
    public static function run(){
         $route = Route::check();//路由检测
         $config  = require 'Config.php';
         if (in_array($route[0], $config['module_list'])){
            //设置模块常量
            define('MOUDEL_NAME', $route[0]);
            if (count($route) == 2 && empty($route[1])) { //默认home模块
                $controller = 'project\\'.$route[0].'\\index';
                $action = 'index'; 
            } elseif (count($route) == 2 && !empty($route[1])) { //默认home模块
                $controller = 'project\\'.$route[0].'\\'.$route[1];
                $action = $route[1]; 
            } elseif (count($route) == 3 && !empty($route[1]) && empty($route[2])){
                $controller = 'project\\'.$route[0].'\\'. $route[1].'\\index'; 
                $action = 'index';
            } elseif (count($route) == 3 && !empty($route[1]) && !empty($route[2])){
                $controller = 'project\\'.$route[0].'\\'. $route[1].'\\'.$route[2]; 
                $action = $route[2];
            } else {
               $controller = 'project\home\error'; 
               $action = 'error'; 
            } 
         } else { //404
            define('MOUDEL_NAME', 'home');
            $controller = 'project\home\error'; 
            $action = 'error';
         }
         $class = new $controller();
         $class->$action();
    }
}
?>