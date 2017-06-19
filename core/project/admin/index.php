<?php
namespace core\project\admin;
use core\Template;
use core\Db;
class index{
    public function index(){
        
        $temp = new Template();
        
        //基本的模板标签测试 
        
        $temp->assign('hw','1');
        $test_array = ['1','2','3','4'];
        $temp->assign('list',$test_array);
        //读取数据库
        $res =Db::query("SELECT id, `name`, `password` FROM k_account WHERE `name` = 'yankuan' AND `password` = '123456'");  
        print_r($res);
        $temp->display('admin','index');   
    }	   
}
?>