用户Institution
===
`/home/institution/*`


## 注册    
`POST /home/institution/register` 

字段	|描述 |  是否必须 
------------ | -------------| -------------
nickname | 用户昵称  	| Y
phone| 手机号码 | N
email|  邮箱  	| Y
psw  | 密码 8-16位数字or字母 	| Y


**Response**  

```json
{
	"code":20000,
	"response"："register success"
}
```


## 登录
`POST /home/institution/login`

字段	|描述 |  是否必须 
------------ | -------------| -------------
account | 账户(手机号码)  	| Y
psw| 密码  | Y

 **Response**  

```json  
{
	"code":20000,
	"response"："operate success"
}
```

## 登出
`POST /home/institution/logout`

字段	|描述 |  是否必须 
------------ | -------------| -------------
account | 账户(手机号码)  	| Y
psw| 密码  | Y

 **Response**  

```json  
{
	"code":20000,
	"response"："operate success"
}
```


## 获取机构信息
`POST /home/institution/info`

字段	|描述 |  是否必须 
------------ | -------------| -------------
account | 账户(手机号码)  	| Y
psw| 密码  | Y

 **Response**  

```json  
{
	"code":20000,
	"response"："operate success"
}
```


## 更新机构信息
`POST /home/institution/update`

字段	|描述 |  是否必须 
------------ | -------------| -------------
account | 账户(手机号码)  	| Y
psw| 密码  | Y

 **Response**  

```json  
{
	"code":20000,
	"response"："operate success"
}
```

## 通过审核检验(审核xxx)
`POST /home/institution/update`

字段	|描述 |  是否必须 
------------ | -------------| -------------
account | 账户(手机号码)  	| Y
psw| 密码  | Y

 **Response**  

```json  
{
	"code":20000,
	"response"："operate success"
}
```



## 获取机构列表 (未审核的..ect)
`POST /home/institution/lists`

字段	|描述 |  是否必须 
------------ | -------------| -------------
account | 账户(手机号码)  	| Y
psw| 密码  | Y

 **Response**  

```json  
{
	"code":20000,
	"response"："operate success"
}
```


## 发布课程