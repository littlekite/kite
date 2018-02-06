<?php
namespace project\api;
use core\Db;
class Account{
    public function verifyAdminLoginCheckUsername(){
        $input = input();
        $res = [];
        if (!empty($input['userName'])) {
            $res_query = Db::query("SELECT id, `name`, `password` FROM k_account WHERE name = '".$input['userName']."'");
            if (empty($res_query)) {
                $res['status'] = 2;//成功
                $res['info'] = "用户名不存在";
            }
        } else {
            $res['status'] = 2;//失败
            $res['info'] = "参数不全";
        }
        echo json_encode($res);
    }
    public function verifyLogin(){
        
        echo 1;
        
    }
}
?>