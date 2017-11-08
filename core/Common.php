<?php
use core\Input;
use core\Log;
/**
 * 获取请求参数
 * @return array 返回参数集合
 */
function input()
{
    return input::get();
}
function writelog($msg = '')
{
    Log::record($msg,'error');
    return "{'code':100,'msg':$msg}";
}
//api 专用
function msgRes($msg = '', $type = 'return')
{
    if(KITE_DEBUG){
        Log::record($msg, $type);  
    } 
    return json_encode($msg);
}
?>