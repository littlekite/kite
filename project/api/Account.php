<?php
namespace project\api;
use core\Db;
class Account{
    /**
     * Account::verifyAdminLogin()
     * 后台登录验证接口
     * @param userName 用户名  passWord 密码
     * @return array['status'返回结果代码info返回结果详情]
     */
    public function verifyAdminLogin(){  
        $res = [];
        $input = input();
        if (!empty($input['username']) && !empty($input['password'])) {
            $res_query = Db::query("SELECT id, `name`, `password` FROM k_account WHERE name = '".$input['username']."'");
            if (!empty($res_query[0])) {
                //开始检查密码
                if ($res_query[0]['password'] == $input['password']) {
                    $res['status'] = 1;//有效用户名
                    $res['info'] = "用户名有效";
                } else {
                    $res['status'] = 2;//密码对不上
                    $res['info'] = "密码错误";
                }
            } else {
                $res['status'] = 2;//成功
                $res['info'] = "用户名不存在";
            }
        } else {
            $res['status'] = 2;//失败
            $res['info'] = "参数不全";
        }
        echo json_encode($res);  
    }
}
?>