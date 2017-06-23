<?php
namespace core\home\index;
use core\Template;
class error{
    public function error(){
        $temp = new Template();
        $temp->display('home/index/error');   
    }	   
}
?>