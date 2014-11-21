<?php
//线上线下公共配置
$common_config = array(
        'URL_MODEL' => 2, //URL模式 REWRITE模式
        'DB_TYPE' => 'mysql', // 数据库类型
        'DB_HOST' => 'localhost', // 服务器地址
        'DB_NAME' => 'mz', // 数据库名
        // 用户名&密码&端口 在server_config.php中配置
        // 'DB_USER' => 'root', // 用户名
        // 'DB_PWD' => 'root', // 密码
        // 'DB_PORT' => '3306', // 端口
        'DB_PREFIX' => 'mz_', // 数据库表前缀
        'LOAD_EXT_FILE' => 'functions', // 自定义加载函数文件
         /////自定义参数
        'UPLOAD_PATH' => './Uploads/', // 上传路径
        'UPLOAD_PATH_ABS' => '/mz/Uploads/', // 上传相对项目路径
        //邮件配置
        'THINK_EMAIL' => array(
                'SMTP_HOST'   => 'smtp.yeah.net', //SMTP服务器
                'SMTP_PORT'   => '465', //SMTP服务器端口
                'SMTP_USER'   => 'dgjnpx@yeah.net', //SMTP服务器用户名
                'SMTP_PASS'   => 'dgjnpx2014', //SMTP服务器密码
                'FROM_EMAIL'  => 'dgjnpx@yeah.net', //发件人EMAIL
                'FROM_NAME'   => '东莞技能培训', //发件人名称
                'REPLY_EMAIL' => '', //回复EMAIL（留空则为发件人EMAIL）
                'REPLY_NAME'  => '', //回复名称（留空则为发件人名称）
        ),
);

//线上配置，只要有server_confi.php这个文件 就会读取这里的配置
$_Server_Config_File = CONF_PATH.'/server_config.php';
if(file_exists($_Server_Config_File)){
    $config = require($_Server_Config_File);
    return array($config,$common_config);
}else{
    //默认的测试环境配置
    return array($common_config,array(
            'SHOW_PAGE_TRACE' => true, // 显示页面Trace信息
            'DB_USER' => 'root', // 用户名
            'DB_PWD' => 'root', // 密码
            'DB_PORT' => '3306', // 端口
    ));
}
