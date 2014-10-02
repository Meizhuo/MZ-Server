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
title  | 类似的资格名称 | N


**Response**  

```json
{
    "code":20000,
    "response"："remove successfully"
}
```

TODO 根据

查询维度：
certificate_type 证书类别
kind 项目类别
level  等级
money  补贴金额
series 系列
title 资格名称
