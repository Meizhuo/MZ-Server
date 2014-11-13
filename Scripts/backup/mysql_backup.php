<?php
$config = require_once '../__config__.php';

/** 
 * Mysql 备份
 * @author Jayin Ton
 * @param  string $mysql_user       mysql 登录用户
 * @param  string $mysql_password   mysql 密码
 * @param  stgring $database        需要你备份的数据库
 * @param  string $backup_file     备份保存文件
 * @param  string $mysql_bin_folder mysql目录 若已配置到环境,可以忽略,若没有配置，请给出Mysql bin/目录的路径
 * @return boolean True if backup successfully
 */
function mysql_backup($mysql_user,$mysql_password,$database,$backup_file,$mysql_bin_folder = null){
     if(is_null($mysql_bin_folder) || empty($mysql_bin_folder)){
         $mysqldump = "mysqldump";
     }else{
        $mysqldump = $mysql_bin_folder."mysqldump";
     }
     $cmd = $mysqldump.' -u '.$mysql_user.' --password='.$mysql_password.' --database  '.$database.' > '.$backup_file;
     exec ($cmd ,  $output , $return_var  );
     if($return_var == 0 ){
            return array('status' => true);
     }
     return array('status' => false,'msg' => $output);
}
//生成备份文件路径
date_default_timezone_set("Asia/Hong_Kong");
if(isset($config['MYSQL_BACKUP_FOLDER'])){
	$backup_file =  $config['MYSQL_BACKUP_FOLDER'].date("Y-m-d-h_i_s").'.sql';
}else{
	$backup_file =  $config['DEFAULT_MYSQL_BACKUP_FOLDER'].date("Y-m-d-h_i_s").'.sql';
}
$res = mysql_backup($config['DB_USER'], $config['DB_PWD'], $config['DB_NAME'],$backup_file);
if($res['status']){
	exit("Backup Successfully!");
}
exit("Backup Faild!");
