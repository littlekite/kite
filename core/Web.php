<?php
namespace core;
class Web{
    public function run(){
         $route = Route::check();//路由检测
         $controller = 'core\project\\'.$route[0].'\\'.$route[1];
         $class = new $controller();
         $class->$route[1]();
    }
}
?>