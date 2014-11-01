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