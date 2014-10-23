Security
===

用户忘记密码实现思路：https://github.com/meizhuolib/MZ-Server/issues/58

## 修改密码  
`POST /home/security/changePsw` 

**注意检查登录状态 以及密码长度**

字段  |描述 |  是否必须 
------------ | -------------| -------------
old_psw | 旧密码     | Y
new_psw|  新密码     | Y



## 创建链接+发送邮件到用户 
`POST /home/security/createLink` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
email | 用户电子邮箱    | Y
 


## 邮箱中的链接是否有效  
`POST /home/security/vertify` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
code | 加密后的钥匙(时间戳+随机串+md5)    | Y
e|  电子邮箱     | Y
psw|  新密码     | Y




