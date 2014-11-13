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


### URL重写
[ Apache ]
httpd.conf配置文件中加载了mod_rewrite.so模块
AllowOverride None 将None改为 All
把下面的内容保存为.htaccess文件放到应用入口文件的同级目录下
```
<IfModule mod_rewrite.c>
 RewriteEngine on
 RewriteCond %{REQUEST_FILENAME} !-d
 RewriteCond %{REQUEST_FILENAME} !-f
 RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
</IfModule>
```


### apache设置自己的404错误页面


* 第一步:让apache支持.htaccess
我们要找到apache安装目录下的httpd.conf文件,在里面找到
```
<Directory />
    Options FollowSymLinks
    AllowOverride none
</Directory>
```
我们只要把蓝色字的none改all就重起apache就OK了

* 第二步:现在就要让网站找不到的内容调到我指定的404页面了,我是在网站的根目录下直接自己创建一个.htaccess文件，
内容为 ErrorDocument 404 /404.html

* 第三步：在网站的根目录（apache配置文件中指定的Document的目录,wamp中就是www/目录）建立自己想要的404.html

注：404文件为404.html （重要提示404页面的大小必须大于512B，否则APACHE忽略）
提示：主要问题是在刚开始做的时候一直在找.htaccess这个文件，其实要自己创建在项目目录下新建一个


