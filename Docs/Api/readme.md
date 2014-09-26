API List
===
## NOTE

BaseURL = http://61.29.161.61:88/mz/index.php

## API规范

**正常响应的时候直接返回**

* 如果是一个对象,例如只是一个用户的资料，那么直接返回:

```json
{
	"code":200,
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
	"coode":200,
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


## API列表

* [应用信息](api_AppInfo.md)
>更新信息

* [用户](api_User.md)