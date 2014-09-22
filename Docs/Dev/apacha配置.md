### 外网无法访问某目录 403
apache/httpd.conf
配置如下 
```xml
<Directory />
    AllowOverride none
    Order allow,deny
    Allow from all
    #Require all denied #注释掉,因为这里把所有请求拒绝掉
</Directory>
```


<Directory "E:/phpenv/wamp/www/">
    Options Indexes FollowSymLinks
 
    AllowOverride all
  
    # Require local  #注释掉或改成Require all
</Directory>



