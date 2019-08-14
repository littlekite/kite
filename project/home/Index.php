<?php
namespace project\home;
use core\Template;
use core\Db;
use core\tpcl\ComFun\ComFun;
class Index{
    public function index(){
        $temp = new Template();
        echo 122222222222;
        $temp->display('index');
    }	   
}
/*
使用文档
图片命名
use core\tpcl\ComFun\ComFun;
$s = ComFun::createRandomStr(4);
        
$s = ComFun::createRandomStr(4);
echo date('YmdHis').rand(1000,9999).'.kite_'."$s".".400_400"."<br/>";
$s = ComFun::createRandomStr(4);
echo date('YmdHis').rand(1000,9999).'.kite_'."$s".".400_400"."<br/>";
$s = ComFun::createRandomStr(4);
echo date('YmdHis').rand(1000,9999).'.kite_'."$s".".400_400"."<br/>";
$s = ComFun::createRandomStr(4);
echo date('YmdHis').rand(1000,9999).'.kite_'."$s".".400_400"."<br/>";
//if
{if ($list)}
    {if(count($list)==1)}
    {$list[0]['name']}
    {else}
    {$list[1]['name']}
    {/if}
{/if}   
//循环语句
{foreach($list as $k=>$r)}
{$r['id']}
{/foreach}
*/
?>