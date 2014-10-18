Advertisement
===
广告

* 表名：mz_advertisement

字段名|描述
---|---
id | 广告id
description | 广告描述
url | 广告链接
pic_url  | 图片链接
display | 是否显示， 0 否 1 是

**权限 只有管理员才能发广告**

### 获得当前的广告信息    
`GET /home/ad/current` 
 
**Response**  

```json  
{
    "code":20000,
    "response"：
    [
        {
               "id": 1,  //广告id
               "description": 1,  //描述
               "url": "/mz/xxx", //相对路径
               "pic_url": 1, // 图片链接
         },
        //....
    ]
}
```

### 增加一条广告信息    
`POST /home/ad/post` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
description | 广告描述     | Y
url | 广告链接          | Y
pic_url  | 图片链接     | Y
display  | 默认0 | N
 
**Response**  

```json  
{
    "code":20000,
    "response"：
    [
        {
               "id": 1,  //广告id
               "description": 1,  //描述
               "url": "/mz/xxx", //相对路径
               "pic_url": 1, // 图片链接
         },
        //....
    ]
}
```

### 上架(显示)一条广告 
`POST /home/ad/diplayAd` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
ad_id | 广告id   | Y
 
**Response**  

```json  
{
    "code":20000,
    "response"："operate successfully";
}
```


### 下架(不显示)一条广告 
`POST /home/ad/undisplayAd` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
ad_id | 广告id  | Y
 
**Response**  

```json  
{
    "code":20000,
    "response"："operate successfully";
}
```

### 删除一条广告 
`POST /home/ad/delete` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
ad_id | 广告id  | Y
 
**Response**  

```json  
{
    "code":20000,
    "response"："operate successfully";
}
```


## 根据文档创建广告
`POST /home/ad/createByDoc` 

**NOTE:文档必须要有图片**

字段  |描述 |  是否必须 
------------ | -------------| -------------
doc_id| 文档id   | Y

**Response**  

```json
{
    "code":20000,
    "response"："operate successfully"
}
```