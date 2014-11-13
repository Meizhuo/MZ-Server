<?php
//服务端应该配置一个server_config.php
if(file_exists('server_config.php')){
	return require 'server_config.php';
}
return array(
	'DB_HOST' => 'localhost', // 服务器地址
	'DB_NAME' => 'mz', // 数据库名
	'DB_USER' => 'root', // 用户名
	'DB_PWD' => 'root', // 密码
	'DB_PORT' => '3306', // 端口
	//backup
// 	'MYSQL_BACKUP_FOLDER' => 'E:\phpenv\mysql_backup\\', //指定MySQL备份的目录
	'DEFAULT_MYSQL_BACKUP_FOLDER' => '../../Backup/',//也就是项目目录的'Backup/'
);