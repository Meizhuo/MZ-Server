课程Course
===
`/home/course/*`

**注意检查权限**




## 发布课程(未完成)
`POST /home/course/post`


字段  |描述 |  是否必须 
------------ | -------------| -------------
institution_id | 所属的培训机构id | Y  
subsidy_id |对应的补贴项目id  | N    
name |课程名称 (可空  | N
start_time |开课时间 时间戳 可空 | N
address |开课地址  可空 | N
teacher |授课老师 可空 | N
introduction |课程介绍 可空 | N
cost |课程费用  可空 | N
end_time |开课结束时间 时间戳 可空 | N

理论上可以基本上可以为空，但逻辑上不该这样
 **Response**  

```json  
{
    "code":20000,
    "response"："post successfully"
}
```

## 更新课程
`POST /home/course/update`

字段  |描述 |  是否必须 
------------ | -------------| -------------
institution_id | 所属的培训机构id | N  
subsidy_id |对应的补贴项目id  | N    
name |课程名称 (可空  | N
start_time |开课时间 时间戳 可空 | N
address |开课地址  可空 | N
teacher |授课老师 可空 | N
introduction |课程介绍 可空 | N
cost |课程费用  可空 | N
end_time |开课结束时间 时间戳 可空 | N

 **Response**  

```json  
{
    "code":20000,
    "response"："update successfully"
}
```

## 删除课程(未完成)
`POST /home/course/delete`

字段  |描述 |  是否必须 
------------ | -------------| -------------
course_id |课程id| Y

 **Response**  

```json  
{
    "code":20000,
    "response"："delete successfully"
}
```

##  课程列表(模糊查询)
`GET /home/course/search`

字段  |描述 |  是否必须 
------------ | -------------| -------------
name |课程名称 (可空 | N 
page | 页码 默认1 | N
limit| 返回数目 默认10|  N
 
**无筛选参数都没就代表选择所有**

**TODO**

* 根据补贴项目(资格名称、培训机构相关)来搜索
* 根据费用范围查询

**Response**  

```json  
{
    "code":20000,
    "response"：[
        {

            "id":"foo",
            "institution_id":"foo",
            "subsidy_id":"foo",
            "name":"foo",
            "start_time":"foo",
            "address":"foo",
            "teacher":"foo",
            "cost":"foo",
            "end_time":"foo",
        }
        ..{
            ...
        }
    ]
}
```

 