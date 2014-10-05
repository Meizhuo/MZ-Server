用户Employer
===
`/home/employer/*`


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


## 获取用人单位信息
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


## 更新用人单位信息
`POST /home/employer/update`

字段  |描述 |  是否必须 
------------ | -------------| -------------
nickname | 用户单位名称     | Y
contact_phone | 联系电话 | N
address  |用人单位地址 | N

 **Response**  

```json  
{
    "code":20000,
    "response"："update success"
}
```
 



 



