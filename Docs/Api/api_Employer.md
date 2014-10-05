用户Employer
===
`/home/employer/*`


## 注册    
`POST /home/employer/register` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
nickname | 用户昵称     | Y
email|  邮箱      | Y
psw  | 密码 8-16位数字or字母   | Y
phone| 手机号码 | N
name |机构名称  | N
address |机构地址 | N
manager |机构负责人 | N
type  |办学类型 | N
approval_number |批准文号 | N
validity_date |有效期(时间戳)  | N
training_scope |培训范围 | N



**Response**  

```json
{
    "code":20000,
    "response"："register success"
}
```


## 登录
`POST /home/employer/login`

字段  |描述 |  是否必须 
------------ | -------------| -------------
account | 账户(邮箱)    | Y
psw| 密码  | Y

 **Response**  

```json  
{
    "code":20000,
    "response"："operate success"
}
```

## 登出
`POST /home/employer/logout`

字段  |描述 |  是否必须 
------------ | -------------| -------------
account | 账户(手机号码)      | Y
psw| 密码  | Y

 **Response**  

```json  
{
    "code":20000,
    "response"："operate success"
}
```


## 获取用人信息
`GET /home/employer/info`

**Response**  

```json  
{
    "code":200,
    "response":{
       "nickname":"foo",
       "phone":"foo",
       "email":""foo"",
       "reg_time":"1412322430",
       "level":"4",
       "status":"1",
       "uid":"15",
       "name":"foo",
       "address":"foo",
       "manager":"foo",
       "type":"foo",
       "approval_number":"foo",
       "validity_date":"foo",
       "training_scope":"foo",
       "description":"foo",
       "teacher_resource":"foo"
    }
}
```


## 更新机构信息
`POST /home/employer/update`

字段  |描述 |  是否必须 
------------ | -------------| -------------
name |机构名称  | N
address |机构地址 | N
manager |机构负责人 | N
type  |办学类型 | N
approval_number |批准文号 | N
validity_date |有效期(时间戳)  | N
training_scope |培训范围 | N

 **Response**  

```json  
{
    "code":20000,
    "response"："update success"
}
```
 



 



