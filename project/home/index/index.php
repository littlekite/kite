<?php
namespace project\home\index;
use core\Template;
use core\Db;
use core\tpcl\UserInfo\UserInfo;
class index{
    public function index(){
        $temp = new Template();
        //基本的模板标签测试 
        $temp->assign('hw','1');
        
        //读取数据库
        $res =Db::query("SELECT id, `name`, `password` FROM k_account");  
        $temp->assign('list',$res);
        $temp->display('project/home/index/index');   
    }	   
}
?>