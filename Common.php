<?php
use Kite\Input;
use Kite\Log;
/**
 * 获取请求参数
 * @return array 返回参数集合
 */
function input()
{
    return Input::get();
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