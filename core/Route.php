<?php
namespace core;
class Route{
    public static function check(){
        if(isset($_SERVER['PATH_INFO'])){
            $path_info = ltrim($_SERVER['PATH_INFO'], '/');
            $path = explode('/', $path_info);
            return $path;
        }    
    }
}
?>