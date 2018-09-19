<?php
namespace core\tpcl\ComFun;

/** 
 * @package 函数库
 * @version 1.1
 */
 
class ComFun{
    
    /**
     * ComFun::createRandomStr()
     * @introduce 产生一组随机字符
     * @param mixed $length
     * @return 随机字符串
     */
    public static function createRandomStr($length){ 
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';//62个字符 
        $strlen = 62; 
        while($length > $strlen){ 
            $str .= $str; 
            $strlen += 62; 
        } 
        $str = str_shuffle($str); 
        return substr($str,0,$length); 
    }   
}