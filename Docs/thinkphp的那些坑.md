### define ( 'BIND_MODULE','Admin');
真是神奇了.如果这样设置了
>之前默认的`http://localhost/myapp/index.php/Home/Index/Index`
变为这样访问:`http://localhost/myapp/index.php/Index/Index`

省了对应模块。有点不一致。。

### Model.save();
如果保存的数据$data为空，也就是array()，逻辑上来说，应该是不做操作，但是却执行生成了sql 而且是错误的 `update xxxx set where id=yy` 可以看出set字段是木有，导致发生错误


### Model join操作后Field字段排除错误
```php
$a = D('user');
//这样我们可以获得全部字段
$a->join('user_info ON user.id = user_info.id')->field(true)->select();

//但是一般情况下 ，我们要是筛选出一些字段:
$a->join('user_info ON user.id = user_info.id')->field('id,username,description')->select();
//好了 你会发现这里会报错，报了个`column id is ambiguous`,因为2表合并的时候id是有2个：user.id 和user_info.id
//所以要指定一下 `表名.字段`
$a->join('user_info ON user.id = user_info.id')->field('user.id,username,description.....')->select();

//跟进一步，比如密码psw就不该选择出来返回给客户端，但同时你发现，若只有一个密码字段不用取，那么干脆使用字段排除算了
//于是:
$a->join('user_info ON user.id = user_info.id')->field('psw',true)->select();

//妈蛋，发现又来个`column id is ambiguous` 的错误,这么一想哩，原因就是有2个id，不知道返回那个，导致的
//所以：
$a->join('user_info ON user.id = user_info.id')->field('user.id,psw',true)->select();

```
好了，到了这里，还是报`column id is ambiguous`的错误，依旧无法排除其中id的，个人感觉 ，其实这是ThinkPHP的一个Bug

解决办法：不用过滤咯，自行指定返回字段