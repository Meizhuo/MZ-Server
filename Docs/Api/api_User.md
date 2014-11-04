用户User
===
`/home/User/*`



## 登录
`POST /home/user/login`

字段	|描述 |  是否必须 
------------ | -------------| -------------
account | 账户(手机号码,邮箱)  	| Y
psw| 密码  | Y

 **Response**  

```json  
{
	"code":20000,
	"response"： {
        "uid": "1",
        "nickname": "superadmin",
        "phone": null,
        "email": "superadmin@mz.com",
        "reg_time": "1411877304",
        "level": "16",
        "status": "1"
    }
}
```

## 登出
`GET /home/user/logout`


**Response**  

```json  
{
	"code":20000,
	"response"："operate successfully"
}
```



 



