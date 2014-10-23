开发规范
===


# 数据库
* 数据库为mz
* 表前缀mz

* Home模块尽量都放置API 接口,其他模块都是处理混合View的接口

Develope Tips
===

* **Controller** 
若需要对请求添加额外的要求：例如需要登录，需要POST and post的字段
```php
//需要登录，需要post doc_id字段
$this->reqPost(array('doc_id'))->reqLogin()
```

若要自定自己的require xxx ，举个例子:
```php
    //再对应的Controlller中定义
    protected function reqPermission(){
        $person = D('User')->createInstution(session('uid'))->getData();
        if($person['level'] != UserModel::LEVEL_INSTITUTION || $person['status'] != UserModel::STATUS_PASS){
            $this->ajaxReturn(mz_json_error('Permission Refused:   你不是机构用户  or 机构未通过审核'));
        }
        return $this;
    }
```


* **Controller**
约定：控制器中的方法为private 是不暴露给客户端
只有public 方法的都暴露给客户端

当然,这只是一种开发中的约定


* **邮件服务**
使用PHPMailer,若直接clone PHPMailer是不行的，需要在`class.phpmailer.php`中首行加入
```php
require 'PHPMailerAutoload.php';
```
这样才能使用类SMTP

