<?php
namespace core;
class Kite{
    public static function run(){
         $route = Route::check();//路由检测
         if (count($route) == 2) { //默认home模块
            $controller = 'project\home\\'.$route[0].'\\'.$route[1];
            $action = $route[1]; 
         } else if(count($route) == 3){
            $controller = 'project\\'. $route[0].'\\'. $route[1].'\\'.$route[2]; 
            $action = $route[2];
         } else {
            $controller = 'project\home\index\error'; 
            $action = 'error';
         }
         $class = new $controller();
         $class->$action();
    }
}
?>