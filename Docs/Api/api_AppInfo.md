AppInfo
===

### 获取应用信息    
`GET /home/app/getVersionInfo` 
 
**Response**  

```json
{
    "id": "1",
    "version_name": "1.0.0",
    "version_code": "1",
    "description": "first version",
    "url":"http://61.1.1.1/mz/apk/a.apk",
    "need_update" :"0" //是否强制更新(0否 1是)
}
```


### 添加应用信息     
`POST /home/app/addNewVersion`     

字段	|描述 |  是否必须 
------------ | -------------| -------------
version_name | 版本代号  	| Y
version_code | 版本号  	    | Y
description  | 版本描述  	| Y
url          | 下载链接     | Y
need_update  | 是否强制更新 | Y

**Response** 

```json
{
    "code": 200,
    "msg": "operate success"
}
```