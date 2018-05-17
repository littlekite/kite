<?php
namespace project\home;
use core\Template;
use core\Db;
use core\tpcl\UserInfo\UserInfo;
class index{
    public function index(){
        $temp = new Template();
        //读取数据库
        /*
        $res = Db::query("SELECT id, `name`, `password` FROM k_account");
        $temp->assign('list',$res);
        */
        $temp->display('index');   
    }	   
}
/*
{if ($list)}
    {if(count($list)==1)}
    {$list[0]['name']}
    {else}
    {$list[1]['name']}
    {/if}
{/if}   
{foreach($list as $k=>$r)}
{$r['id']}
{/foreach}
*/
?>

