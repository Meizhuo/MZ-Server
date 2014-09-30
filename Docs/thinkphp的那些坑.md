### Model.save();
如果保存的数据$data为空，也就是array()，逻辑上来说，应该是不做操作，但是却执行生成了sql 而且是错误的 `update xxxx set where id=yy` 可以看出set字段是木有，导致发生错误