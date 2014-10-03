补贴项目Subsidy
===
`/home/subsidy/*`

## 添加项目
`POST /home/subsidy/post` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
certificate_type | 证书类别   | Y
kind | 项目类别   | Y
level | 等级   | Y
money | 补贴金额   | Y
series | 系列   | Y
title | 资格名称   | Y

**Response**  

```json
{
    "code":20000,
    "response"："post successfully"
}
```

## 更新项目
`POST /home/subsidy/update` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
subsidy_id | 补贴项目id | Y
certificate_type | 证书类别   | N
kind | 项目类别   | N
level | 等级   | N
money | 补贴金额   | N
series | 系列   | N
title | 资格名称   | N

**Response**  

```json
{
    "code":20000,
    "response"："update successfully"
}
```


## 删除项目
`POST /home/subsidy/remove` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
subsidy_id | 补贴项目id | Y


**Response**  

```json
{
    "code":20000,
    "response"："remove successfully"
}
```

## 查询
`GET /home/subsidy/search` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
~|没有任何参数就返回查询全部|~
title  |  资格名称(通常只用到这个) | N
kind   |  项目类别|N
level  |  等级 |N
series   | 系列|N
limit  | 返回条目 默认10|N
page   | 页码  默认1| N


**Response**  

```json
{   
    "code":200,
    "response":[     
       {  "id":"1",
           "certificate_type":"foo"
           ,"kind":"foo"
           ,"level":"foo"
           ,"money":"foo"
           ,"series":"foo"
           ,"title":"foo"
       }
        .....
    ]
```


## 获得证书类别的种类
`GET /home/subsidy/getCertificateTypes` 

**Response**  

```json
{
    "code":20000,
    "response"：[
            {"certificate_type":"xxx"}.....
    ]
}
```

## 获得项目类别的种类
`GET /home/subsidy/getkinds` 

**Response**  

```json
{
    "code":20000,
    "response"：[
            {"kind":"xxx"}.....
    ]
}
```


## 获得级别的种类
`GET /home/subsidy/getLevels` 

**Response**  

```json
{
    "code":20000,
    "response"：[
            {"level":"xxx"}.....
    ]
}
```


## 获得系列的种类
`GET /home/subsidy/getSeries` 

**Response**  

```json
{
    "code":20000,
    "response"：[
            {"series":"xxx"}.....
    ]
}
```


## 获得资格名称的种类
`GET /home/subsidy/getTitles` 

**Response**  

```json
{
    "code":20000,
    "response"：[
            {"title":"xxx"}.....
    ]
}
```

