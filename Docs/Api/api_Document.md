文档模块Document
===
`/home/document/*`


## 发布文档 
`POST /home/document/post` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
title | 标题      | Y
content | 内容   |Y
category_id |  所属分类(栏目)   |Y
display| 可见性( 0 不可见1可见,默认1可见) | N
status| 审核状态(-1审核不通过 0未审核 1审核通过)默认0 | N
from| 新闻来源  | N
level| 文章等级(1 只有个人用户可见 2 只有用人单位可见  4只有培训机构可见8 只有管理员可见 16只有超级管理员可见 31全部可见,默认31) | N
description| 简单描述 | N
order_num| 序号(优先级别,默认为1) | N
vertify_uid  |审核人id | N
vertify_time |审核时间 | N


**Response**  

```json
{
    "code":20000,
    "response"："post successfully"
}
```


## 编辑/更新文档  
`POST /home/document/update` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
doc_id|文档id|Y
title | 标题      | N
content | 内容   |N
category_id |  所属分类(栏目)   |N
display| 可见性( 0 不可见1可见,默认1可见) | N
status| 审核状态(-1审核不通过 0未审核 1审核通过) | N
from| 新闻来源  | N
level| 文章等级(1 只有个人用户可见 2 只有用人单位可见  4只有培训机构可见8 只有管理员可见 16只有超级管理员可见 31全部可见,默认31) | N
description| 简单描述 | N
order_num| 序号(优先级别,默认为1) | N
vertify_uid  |审核人id | N
vertify_time |审核时间 | N

**Response**  

```json
{
    "code":20000,
    "response"："update successfully"
}
```


## 文档详情
`GET /home/document/info` 
字段  |描述 |  是否必须 
------------ | -------------| -------------
doc_id | 标题      | N


**Response**  

```json
{
    "code":20000,
    "response"：{
        "id":"1",
        "uid":"1",
        "title":"Title!!",
        "category_id":"2",
        "display":"1",
        "status":"1",
        "views":"0",
        "create_time":"1412512673",
        "update_time":"1412567712",
        "from":null,
        "level":"31",
        "description":null,
        "order_num":"1",
        "content":"&lt;h1&gt;content&lt;\/h1&gt;....",
        "files":[
            {
                "id":"53",
                "doc_id":"166",
                "raw_name":"11.doc",
                "save_name":"543ffe738edb5.doc",
                "save_path":"2014-10-17\/",
                "ext":"doc",
                "mime":"application\/msword",
                "size":"25600",
                "md5":"283ec47cb110888a841614d7952ae6f5",
                "create_time":"1413480051"
            },
            ....
        ]
    }
}
```



## 文档列表(查询)
`GET /home/document/search` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
category_id|栏目id (获取指定栏目下的)| N 
title | 类似的标题      | N
content | 类似的内容   |N
page| 页码,默认1|N
limit| 条目,默认10| N

**Response**  

```json
{
    "code": 200,
    "response": [
        {
            "id": "2",
            "uid": "1",
            "title": "title22",
            "category_id": "2",
            "display": "1",
            "status": "0",
            "views": "0",
            "create_time": "1412534968",
            "update_time": "0",
            "from": null,
            "level": "31",
            "description": null,
            "order_num": "1",
            "content": "这是！content",
        }
    ]
}
```


## 获得文档分类
`GET /home/document/getCategory`

**Response**  

```json
{
    "code":20000,
    "response"："[
        {
            "category_id":123// 分类id
            "category":"职业培训" //种类名称
            "name":"最新通知"// 子种类名称
            "description":"hello world" // 描述 

        }
        ......

    ]
}
```


## 审核文档  
`POST /home/document/vertify` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
doc_id|需要审核的文档id|Y
op|operation的简称(0为通过 1为不通过审核，默认1)| N

**Response**  

```json
{
    "code":20000,
    "response"："vertify successfully"
}
```


## 上传附件 
`POST /home/document/upload` 

NOTE:先发布了文章再允许添加附件

字段  |描述 |  是否必须 
------------ | -------------| -------------
file| 需要上传的文件   | Y

**Response**  

```json
{
    "code":20000,
    //上传附件信息
    "response"：{
        "id":"20",
        "doc_id":"0",
        "raw_name":"abc_menu_dropdown_panel_holo_dark.9.png",
        "save_name":"543f7186c4cf5.png",
        "save_path":"2014-10-16/",
        "ext":"png",
        "mime":"image/png",
        "size":"1226",
        "md5":"f25634dba4131278cd28b24ee991ceaa",
        "create_time":"1413443974",
        "ins_id" : "0" 
    }
}
```

## 获得文档文档的附件
`GET /home/document/getDocFile` 


字段  |描述 |  是否必须 
------------ | -------------| -------------
doc_id | 文档的id   | Y

**Response**  

```json
{
    "code": 200,
    "response": [
        {
            "id": "8",
            "doc_id": "1",
            "raw_name": "11.doc",
            "save_name": "54378ff6e9ba4.doc",
            "save_path": "2014-10-10/",
            "ext": "doc",
            "mime": "application/msword",
            "size": "25600",
            "md5": "283ec47cb110888a841614d7952ae6f5",
            "create_time": "1412927478",
            "ins_id":0;
        }
        ....
    ]
}
```

## 删除附件 
`POST /home/document/deleteFile` 

~~NOTE:先发布了文章再允许添加附件~~

字段  |描述 |  是否必须 
------------ | -------------| -------------
file_id| 文档id   | Y

**Response**  

```json
{
    "code":20000,
    "response"："delete successfully"
}
```

查看文档的网页版
===
`GET /admin/index/viewDocument`

字段  |描述 |  是否必须 
------------ | -------------| -------------
doc_id| 文档id   | Y

**Response**  

html 网页



