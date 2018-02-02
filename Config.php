<?php
return [
    'type'           => 'mysql',
    // 服务器地址
    'hostname'       => '127.0.0.1',
    // 数据库名
    'database'       => 'test',
    // 用户名
    'username'       => 'root',
    // 密码
    'password'       => '',
    // 端口
    'hostport'       => '3306',
    // 连接dsn
    'dsn'            => '',
    // 数据库连接参数
    'params'         => [],
    // 数据库编码默认采用utf8
    'charset'        => 'utf8',
    // 数据库表前缀
    'prefix'         => 'k_',
    // 数据库调试模式
    'debug'          => true,
    //日志文件大小
    'file_size'=> 10240,
    //模块列表
    'module_list' => ['home','admin']    
];
