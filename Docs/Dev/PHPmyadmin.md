MySql密码修改  
```shell
$ mysql>bin>mysqladmin -u 用户密码 -p 旧密码 password 新密码
```

修改密码后，进入phpmyadmin会会报错：  
```shell
 #1045 - Access denied for user 'root'@'localhost' (using password: NO)
``` 
原因,请看下一条

### phpmyadmin
WAMP的phpmyadmin默认是基于配置的登录，也就是账号密码都写在配置文件中，这显然不合理(mysql改了密码这样就得手动调，而且外部也能随意进入)
修改`wamp/apps/phpmyadmin/config.inc.php`
```
//改为config -> cookie
$cfg['Servers'][$i]['auth_type'] = 'cookie';
// 注释以下
// $cfg['Servers'][$i]['user'] = 'root';
// $cfg['Servers'][$i]['password'] = '';
```
