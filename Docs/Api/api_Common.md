Common
===
>后台通用接口

## 清除垃圾文件
`GET /admin/common/cleanFile`
满足以下条件就删除：
* doc_id 为0 or 空
* ins_id 为0 or 空

 **Response**  

```json  
{
    "code":20000,
    "response"："清理完毕"
}
```

### 生成二维码
`GET /home/common/createQRcode` 

字段  |描述 |  是否必须 
------------ | -------------| -------------
text | 二维码内容     | Y
size  | 图像长宽 二维码长宽,一般为25的倍数,单位：px | N
margin | 外边距 单位:px | N
 
**Response**

二进制图片