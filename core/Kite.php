<?php
namespace core;
class Kite{
    public static function run(){
         $route = Route::check();//路由检测
         $config  = require 'Config.php';
         if (in_array($route[0], $config['module_list'])){
            //设置模块常量
            define('MOUDEL_NAME', $route[0]);
            //设置当前路径常量
            if (!empty($_SERVER['REQUEST_URI']) && !empty($_SERVER['PATH_INFO'])){
                $pos = strpos($_SERVER['REQUEST_URI'], $_SERVER['PATH_INFO']);
                $view_url = substr($_SERVER['REQUEST_URI'], 0, $pos).'/project/'.MOUDEL_NAME.'/view/';
                define('VIEW_URL', $view_url);
            }
            if (count($route) == 2 && empty($route[1])) { //默认home模块
                $controller = 'project\\'.$route[0].'\\Index';
                $action = 'index';
            } elseif (count($route) == 2 && !empty($route[1])) { //默认home模块
                $controller = 'project\\'.$route[0].'\\'.ucfirst($route[1]);
                $action = $route[1];
            } elseif (count($route) == 3 && !empty($route[1]) && empty($route[2])){
                $controller = 'project\\'.$route[0].'\\'. $route[1].'\\Index'; 
                $action = 'index';
            } elseif (count($route) == 3 && !empty($route[1]) && !empty($route[2])){
                $controller = 'project\\'.$route[0].'\\'. $route[1].'\\'.ucfirst($route[2]); 
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