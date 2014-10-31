用户Admin
===
`/home/admin/*`

##  创建管理员
`POST /home/admin/create` 

字段	|描述 |  是否必须 
------------ | -------------| -------------
nickname | 用户昵称  	| Y
email|  邮箱  	| Y
psw  | 密码 8-16位数字or字母 	| Y


**Response**  

```json
{
	"code":20000,
	"response"："create success"
}
```


## 获取管理员信息
`GET /home/employer/getInfo`

**NOTE:需要管理员权限***

字段  |描述 |  是否必须 
------------ | -------------| -------------
admin_id | 管理员id     | Y

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
       "per_categorys_post":"[]",
       "per_categorys_check":"[]",
       "per_institution_check":"0"
    }
}
```




## 发布文档	
`POST /home/admin/postDocument` 

字段	|描述 |  是否必须 
------------ | -------------| -------------
title | 标题  	| Y
content | 内容   |Y
category_id |  所属分类(栏目)   |Y
upload_ids |  附件id组(json数组),默认[]   |N
display| 可见性( 0 不可见1可见,默认1可见) | N
status| 审核状态(-1审核不通过 0未审核 1审核通过) | N
from| 新闻来源  | N
level| 文章等级(1 只有个人用户可见 2 只有用人单位可见  4只有培训机构可见8 只有管理员可见 16只有超级管理员可见 31全部可见,默认31) | N
description| 简单描述 | N
order_num| 序号(优先级别,默认为1) | N

**Response**  

```json
{
	"code":20000,
	"response"："post successfully"
}
```


## 编辑/更新文档  
`POST /home/admin/updateDocument` 

字段	|描述 |  是否必须 
------------ | -------------| -------------
title | 标题      | N
content | 内容   |N
category_id |  所属分类(栏目)   |N
upload_ids |  附件id组(json数组),默认[]   |N
display| 可见性( 0 不可见1可见,默认1可见) | N
status| 审核状态(-1审核不通过 0未审核 1审核通过) | N
from| 新闻来源  | N
level| 文章等级(1 只有个人用户可见 2 只有用人单位可见  4只有培训机构可见8 只有管理员可见 16只有超级管理员可见 31全部可见,默认31) | N
description| 简单描述 | N
order_num| 序号(优先级别,默认为1) | N

**Response**  

```json
{
    "code":20000,
    "response"："update successfully"
}
```



**分离到其他接口 /home/*/vertify**
================



## 审核文档  
`POST /home/admin/checkDocument` 

字段	|描述 |  是否必须 
------------ | -------------| -------------
doc_id|需要审核的文档id|Y
op|operation的简称(0为通过 1为不通过审核，默认1)| N

**Response**  

```json
{
    "code":20000,
    "response"："check document successfully"
}
```


## 审核培训机构 
`POST /home/admin/checkInstitution` 

字段	|描述 |  是否必须 
------------ | -------------| -------------
ins_id| 需要审核的机构id  	| Y
op|operation的简称(0为通过 1为不通过审核，默认1)| N

**Response**  

```json
{
    "code":20000,
    "response"："check institution successfully"
}
```



## 上传附件
`POST /home/admin/upload` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
file| 需要上传的文件   | Y

**Response**  

```json
{
    "code":20000,
    "response"：{
        //附件的信息
        "id":"foo",
        "name":"foo",
        "ext":"foo",
        "create_time":"foo"
    }
}
```

