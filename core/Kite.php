<?php
namespace core;
class Kite{
    public static function run(){
         $route = Route::check();//路由检测
         if(count($route)==2){ //默认home模块
            $controller = 'core\home\\'.$route[0].'\\'.$route[1];
            $action = $route[1]; 
         } else if(count($route)==3){
            $controller = 'core\\'.$route[0].'\\'.$route[1].'\\'.$route[2]; 
            $action = $route[2];
         } else {
            $controller = 'core\home\index\error'; 
            $action = 'error';
         }
         $class = new $controller();
         $class->$action();
    }
}
?>