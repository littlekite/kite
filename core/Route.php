<?php
namespace core;
class Route{
    //路由检测
    public static function check(){
        if( isset($_SERVER['PATH_INFO']) ){
            if (strrpos($_SERVER['PATH_INFO'], 'html')) {
                 $_SERVER['PATH_INFO'] = substr($_SERVER['PATH_INFO'], 0, -5);
            }
            $path_info = ltrim($_SERVER['PATH_INFO'], '/');
            $path = explode('/', $path_info);
            $path_style = count($path);
            if ($path_style === 1) {
                return array($path[0], 'index');
            } else if ($path_style === 2){ //标准模式
                return $path;
            } else if ($path_style === 3) { //带模块/控制器/
                return $path;
            } else {
                return array('index', 'error');
            }
        } else {
            //直接输入域名 默认到index模块下的index方法
            return array('home', 'index');
        }    
   }
   //ssl检测
   public static function isSsl()
    {
        $server = $_SERVER;
        if (isset($server['HTTPS']) && ('1' == $server['HTTPS'] || 'on' == strtolower($server['HTTPS']))) {
            return true;
        } elseif (isset($server['REQUEST_SCHEME']) && 'https' == $server['REQUEST_SCHEME']) {
            return true;
        } elseif (isset($server['SERVER_PORT']) && ('443' == $server['SERVER_PORT'])) {
            return true;
        } elseif (isset($server['HTTP_X_FORWARDED_PROTO']) && 'https' == $server['HTTP_X_FORWARDED_PROTO']) {
            return true;
        }
        return false;   
    }
   //跳转
   public static function jump($url = ''){
        // 检测域名
        $url = (self::isSsl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'].'/'.$url;
        header('Location: '.$url);
        exit;
   }
}
?>