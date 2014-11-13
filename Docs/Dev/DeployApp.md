DeployApp
===
>应用部署指南

部署工具
===
* WAMP

部署
===

### 下载
```
cd www
git clone https://github.com/meizhuolib/MZ-Server.git
```
把MZ-Server改为mz


### 服务端配置
* 线上配置
`Application/Common/Conf/`中创建`server_config.php`(当然可以参考`_server_config.php`)
在里面输入服务端特有的配置信息(例如数据库连接信息等等)

**注意**`server_config.php`默认是git ignore的，不受版本控制

### 配置MySQL 备份

MySQL备份的脚本在`Scripts/backup` 运行run.bat即可

* 默认是备份到项目的`Backup/`目录，可以在`Script/`下建立一个`server_config.php`来配置

加入：
```
 'MYSQL_BACKUP_FOLDER' => 'E:\phpenv\mysql_backup\\', //指定MySQL备份的目录
 'DEFAULT_MYSQL_BACKUP_FOLDER' => '../../Backup/',//也就是项目目录的'Backup/'
```
**注意** 务必把php 和 mysql的bin目录配置到系统变量中！

More: 可以加入定时任务计划来进行备份



