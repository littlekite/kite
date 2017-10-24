<?php
namespace core\manage\admin;
use core\Template;
use core\Db;
class index extends common{
    public function index(){
        $temp = new Template();
        
        //基本的模板标签测试 
        
        $temp->assign('hw','1');
        $test_array = ['1','2','3','4'];
        $temp->assign('list',$test_array);
        $res =Db::query("SELECT id, `name`, `password` FROM k_account WHERE `name` = ? AND `password` = ?",['yankuan','123456']);  
        print_r($res);
        //读取数据库
        
        $res =Db::execute("SELECT id, `name`, `password` FROM k_account WHERE `name` = 'yankuan' AND `password` = '123456'");  
        
        //存入数据库
        var_dump($res);
        $temp->display('manage/admin/index');   
    }  	   
}
?>