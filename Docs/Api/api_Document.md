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
`POST /home/document/update` 

字段  |描述 |  是否必须 
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


## 文档详情
`GET /home/document/info` 
字段  |描述 |  是否必须 
------------ | -------------| -------------
doc_id | 标题      | N


**Response**  

```json
{
    "code":20000,
    "response"："update successfully"
}
```



## 文档列表(页码，分类)
`GET /home/document/search` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
page| 页码,默认1|N
limit| 条目,默认10| N
title | 类似的标题      | N
content | 类似的内容   |N
category_ids|目录| N




## 获得文档分类
`GET /home/document/category`

**Response**  

```json
{
    "code":20000,
    "response"："[
        {
            "category_id":123// 分类id
            "name":"最新通知"// 种类名称
            "description":"hello world" // 描述 

        }
        ......

    ]
}
```


## 上传附件
`POST /home/admin/upload` 

NOTE:先发布了文章再允许添加附件

字段  |描述 |  是否必须 
------------ | -------------| -------------
file| 需要上传的文件   | Y

**Response**  

```json
{
    "code":20000,
    "response"："upload successfully"
}
```


