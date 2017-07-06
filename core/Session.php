<?php
namespace core;
class Session{
    //销毁SESSION
    public static function clear(){
         // 如果要使用会话，别忘了现在就调用：
        session_start();
        // 重置会话中的所有变量
        $_SESSION = array();
        // 如果要清理的更彻底，那么同时删除会话 cookie
        // 注意：这样不但销毁了会话中的数据，还同时销毁了会话本身
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        // 最后，销毁会话
        session_destroy();
    }
    //启动seesion
    public static function start(){
        session_start();
    }
    //创建seesion
    public static function creat($key,$val){
        if(PHP_SESSION_ACTIVE != session_status()){ //session没有被创建
            session_start();
        } 
        $_SESSION[$key] = $val;
    }
}
?>