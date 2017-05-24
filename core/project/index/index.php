<?php
namespace core\project\index;
use core\Template;
class index{
    public function index(){
        $temp = new Template();
        $temp->display('index','index');
    }	   
}
?>