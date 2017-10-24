<?php
namespace core\manage\login;
use core\Template;
use core\Db;
use core\Session;
class index{
    public function index(){
        $temp = new Template();
        //基本的模板标签测试  
        $temp->assign('hw','1');
        $test_array = ['1','2','3','4'];
        $temp->assign('list',$test_array);
        //$res =Db::query("SELECT id, `name`, `password` FROM k_account WHERE `name` = ? AND `password` = ?",['yankuan','123456']);  
        //读取数据库
        //$res =Db::execute("SELECT id, `name`, `password` FROM k_account WHERE `name` = 'yankuan' AND `password` = '123456'");  
        //存入数据库
        //销毁用户的会话
        Session::clear();
        $temp->display('manage/login/login');   
    } 
    public function login(){
        
    } 	   
}
?>