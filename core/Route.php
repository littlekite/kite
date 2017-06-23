<?php
namespace core;
class Route{
    public static function check(){
        if( isset($_SERVER['PATH_INFO']) ){
            $path_info = ltrim($_SERVER['PATH_INFO'], '/');
            $path = explode('/', $path_info);
            $path_style = count($path);
            if($path_style === 1){
                return array($path[0],'index');
            } else if($path_style === 2){ //标准模式
                return $path;
            } else if($path_style === 3) { //带模块/控制器/
                return $path;
            } else {
                return array('index','error');
            }
        } else {
            //直接输入域名 默认到index模块下的index方法
            return array('index','index');
        }    
    }
}
?>