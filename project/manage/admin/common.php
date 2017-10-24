<?php
namespace core\manage\admin;
use core\Template;
use core\Db;
class common{
   function __construct() {
       //检测用户是否登录
       if(PHP_SESSION_NONE == session_status()){ 
           if( isset($_SESSION['username']) && $_SESSION['username'] != "" ){
               //进入主管理页面
           } else {
               //跳转到登录界面
               $_SESSION['username'] = 1;  
           }
       } else {
          echo "跳转到登录界面";
       }
   }     
}
?>