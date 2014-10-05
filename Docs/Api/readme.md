API List
===
## NOTE

BaseURL = http://61.29.161.61:88/mz/index.php

## API规范

**正常响应的时候直接返回**

* 如果是一个对象,例如只是一个用户的资料，那么直接返回:

```json
{
	"code":20000,
	"response"：{
		"foo":"bar",
		...
		"foox":"barx"
	}
}
```

* 如果是一个列表，例如请求返回一个新闻列表

```json 
{
	"coode":20000,
	"response":[
		{
			"titile":"title1"
			...
		},
		...
		,{
			"titile":"title12"
			...
		}

	]
}

```

* 如果是一个错误，输出错误码以及 错误信息
```json
{
	"error_code":40001,
	"msg":"请求方法错误"
}
```


API文档示例
===
## 注册
`POST /home/user/register`

字段	|描述 |  是否必须 
------------ | -------------| -------------
nickname | 用户昵称  	| Y
 |   | Y

 **Response**
 ```json
{
	"code":20000,
	"response"："operate success"
}
```





## API列表

* [应用信息](api_AppInfo.md)
* [用户User](api_User.md)
* [用户Admin](api_Admin.md)
* [用户Employer](api_Employer.md)
* [用户机构Institution](api_Institution.md)
* [课程](api_Course.md)
* [文档](api_Document.md)
* [补贴项目](api_Subsidy.md)
