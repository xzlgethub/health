<?php
return array(
    //'配置项'=>'配置值'
//    'DOMAIN_NAME'         =>  'http://demo.huliantec.com',
    'DOMAIN_NAME'         =>  'http://localhost/Health',




    'DEFAULT_MODULE'        =>  'App',  // 默认模块
    'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
    'DEFAULT_ACTION'        =>  'index', // 默认操作名称

    //数据库配置
    'DB_TYPE'                => 'mysql', // 数据库类型
    'DB_HOST'                => '127.0.0.1', // 服务器地址
    'DB_NAME'                => 'lifeshare', // 数据库名
    'DB_USER'                => 'root', // 用户名
    'DB_PWD'                 => 'root', // 密码
    'DB_PORT'                => '3306', // 端口
    'DB_PREFIX'              => 'hl_', // 数据库表前缀
    'DB_PARAMS'              => array(), // 数据库连接参数
    'DB_DEBUG'               => true, // 数据库调试模式 开启后可以记录SQL日志
);