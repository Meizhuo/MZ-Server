用户Institution
===
`/home/institution/*`


## 注册    
`POST /home/institution/register` 

字段	|描述 |  是否必须 
------------ | -------------| -------------
nickname | 用户昵称  	| Y
email|  邮箱  	| Y
psw  | 密码 8-16位数字or字母 	| Y
phone| 手机号码 | N
name |机构名称  | N
address |机构地址 | N
manager |机构负责人 | N
type  |办学类型 | N
approval_number |批准文号 | N
validity_date |有效期(时间戳)  | N
training_scope |培训范围 | N
description |描述  | N
teacher_resource |师资力量 | N




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
account | 账户(邮箱)  	| Y
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
`GET /home/institution/info`

字段	|描述 |  是否必须 
------------ | -------------| -------------
institution_id | 机构的id 	| Y

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
`POST /home/institution/update`

字段	|描述 |  是否必须 
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

## 通过审核检验(审核xxx)
`POST /home/institution/check`

字段	|描述 |  是否必须 
------------ | -------------| -------------
ins_id | 账户(手机号码)  	| Y
op| 密码  | Y

 **Response**  

```json  
{
	"code":20000,
	"response"："operate success"
}
```



## 获取机构列表  (模糊查询)
`GET /home/institution/search`

字段	|描述 |  是否必须 
------------ | -------------| -------------
status | 审核状态(-1审核不通过 0 未审核1审核通过(默认全部获取)| N
name |机构名称  | N
type  |办学类型 | N
limit | 返回条目 默认10   	| Y
page| 页码 默认1  | Y


 **Response**  

```json  
{ 
	"code":200,
	"response":[
		{ "uid":"14",
		   "nickname":"\u7aed\u8bda\u57f9\u8bad\u516c\u53f8",
		   "phone":null,
		   "email":"qc@ruby.com",
		   "reg_time":"1412322229",
		   "level":"4",
		   "status":"1",
		   "name":null,
		   "address":null,
		   "type":null,
		   "description":null
		},
        .....
        { ...}
    ]
}
```



