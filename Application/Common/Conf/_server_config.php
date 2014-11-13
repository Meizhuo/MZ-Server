<?php
//上线版本的配置参考
return array(
        'DB_TYPE' => 'mysql', // 数据库类型
        'DB_HOST' => 'localhost', // 服务器地址
        'DB_NAME' => 'mz', // 数据库名
        'DB_USER' => 'root', // 用户名
        'DB_PWD' => 'root', // 密码
        'DB_PORT' => '3306', // 端口
        'DB_PREFIX' => 'mz_', // 数据库表前缀
        // 'SHOW_PAGE_TRACE' => true, // 显示页面Trace信息
        'LOAD_EXT_FILE' => 'functions', // 自定义加载函数文件
         /////自定义参数
        'UPLOAD_PATH' => './Uploads/', // 上传路径
        'UPLOAD_PATH_ABS' => '/mz/Uploads/', // 上传相对项目路径
//         'APP_URL' => 'http://61.29.161.61:88/mz/index.php', //product
//         'APP_URL' => 'http://localhost/mz/index.php',//test
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