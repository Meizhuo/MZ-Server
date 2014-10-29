用户User
===
`/home/person/*`

## 注册    
`POST /home/person/register` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
nickname | 用户昵称     | Y
phone| 手机号码 | Y
email|  邮箱      | N
psw  | 密码 8-16位数字or字母   | Y
sex|    性别(男或女) 默认为男    | N
work_place|  工作地点   | N


**Response**  

```json
{
    "code":20000,
    "response"："operate success"
}
```


## 获得用户资料
`GET /home/person/info`

**Response**
```json
{
    "code":20000,
    "response"：{
        "nickname":"foo", // 用户昵称
        "phone":"foo",  //手机号码 
        "email":"foo@bar.com", //邮箱
        "reg_time":"12345684", //注册时间
        "level":"1", //权限等级
        "status":0 //审核状态(-1审核不通过 0 未审核1审核通过),
        "sex":"男",
        "work_place":"广东江门xx"
    }
}
```

## 更新用户资料
`POST /home/person/update`

字段  |描述 |  是否必须 
------------ | -------------| -------------
nickname | 用户昵称     | N
sex|    性别(男或女) 默认为男    | N
work_place|  工作地点   | N


**Response**  

```json
{
    "code":20000,
    "response"："operate success"
}
```