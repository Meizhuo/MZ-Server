开发规范
===


# 数据库
* 数据库为mz
* 表前缀mz


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


