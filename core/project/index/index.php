<?php
namespace core\project\index;
use core\Template;
class index{
    public function index(){
        $temp = new Template();
        $temp->assign('hw','hello world');
        $test_array = ['1','2','3','4'];
        $temp->assign('list',$test_array);
        $temp->display('index','index');  
    }	   
}
?>