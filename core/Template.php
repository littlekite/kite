<?php
namespace core;
class Template{
    public function display($moudel,$action){
        if(is_file(__DIR__."/project/$action/$action.html")){
            require_once "project/$action/$action.html";
        }else{
            throw new \Exception('template is not found!');
        }  
    }
}
?>