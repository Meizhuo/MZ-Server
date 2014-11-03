用户Employer
===
`/home/employer/*`

用人单位就是企业用户

## 注册    
`POST /home/employer/register` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
nickname | 用户单位名称     | Y
email|  邮箱      | Y
psw  | 密码 8-16位数字or字母   | Y
phone| 手机号码 | N
contact_phone | 联系电话 | N
address  |用人单位地址 | N

**Response**  

```json
{
    "code":20000,
    "response"："register success"
}
```


## 验证(修改企业用户的审核状态)
`POST /home/employer/vertify`

**NOTE:需要管理员有管理企业用户的权限 per_employer_man**

字段  |描述 |  是否必须 
------------ | -------------| -------------
employer_id | 企业用户id  | Y
op | 审核状态(只有（-2 冻结  1审核通过）,其他均不合理) | Y

**Response**  

```json  
{
    "code":200,
    "response":"operate successfully"
}
```


## 删除企业用户
`POST /home/employer/delete`

**NOTE:需要管理员有管理个人用户的权限 per_person_man**

字段  |描述 |  是否必须 
------------ | -------------| -------------
employer_id | 个人用户id  | Y

**Response**  

```json  
{
    "code":200,
    "response":"operate successfully"
}
```



## 获取当前登录的用人单位信息
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
       "contact_phone":"foo",
       "address":"foo"
    }
}
```


## 获取用人单位信息
`GET /home/employer/getInfo`

**NOTE:需要管理员权限***

字段  |描述 |  是否必须 
------------ | -------------| -------------
employer_id | 用人单位的id     | Y

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
       "contact_phone":"foo",
       "address":"foo"
    }
}
```


## 更新用人单位信息
`POST /home/employer/update`

字段  |描述 |  是否必须 
------------ | -------------| -------------
contact_phone | 联系电话 | N
address  |用人单位地址 | N

 **Response**  

```json  
{
    "code":20000,
    "response"："update success"
}
```
 



 



