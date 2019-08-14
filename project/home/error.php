<?php
namespace project\home;
use core\Template;
class error{
    public function error(){
        $temp = new Template();
        $temp->display('error');   
    }	   
}
?>