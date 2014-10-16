<?php
namespace Common\Model;

/**
 * 文档附件模型
 * 
 * @author Jayin
 *        
 */
class DocumentFileModel extends BaseModel {

    protected $_auto = array(
            array(
                    'create_time',
                    NOW_TIME,
                    self::MODEL_INSERT
            )
    );

    /**
     * POST 发布一附件
     * 
     * @param unknown $doc_id
     *            对应的文档id
     * @param unknown $file_info
     *            上传后的文档信息
     * @return Ambigous <string, multitype:number string >
     */
    public function post($doc_id, $file_info) {
        $res = $this->_getResult();
        $data['doc_id'] = $doc_id;
        $data['raw_name'] = $file_info['name'];
        $data['save_name'] = $file_info['savename'];
        $data['save_path'] = $file_info['savepath'];
        $data['ext'] = $file_info['ext'];
        $data['mime'] = $file_info['type'];
        $data['size'] = $file_info['size'];
        $data['md5'] = $file_info['md5'];
        
        if ($this->create($data)) {
            if ($this->add()) {
                $res['status'] = 1;
                // 返回附件插入后的信息
                $upload_file = $this->where("save_path='%s' AND save_name='%s'", 
                        $file_info['savepath'], $file_info['savename'])->select();
                $res['msg'] = $upload_file[0];
            } else {
                $res['msg'] = 'System Error: Not able to insert.';
            }
        } else {
            $res['msg'] = $this->getError();
        }
        return $res;
    }
    /**
     * 更新一文档
     * @param unknown $data 包含id
     * @return Ambigous <number, string, multitype:number string >
     */
    private function update($data){
        $res = $this->_getResult();
        if($this->create($data)){
           if(count($this->data)>1){
               $this->save();
           }
           $res['status'] = 1;
        }else{
            $res['msg'] = $this->getError();
        }
        return $res;
    }

    /**
     * 批量链接到一个文档
     * @param unknown $doc_id 文档id
     * @param array $file_ids
     * @return Ambigous <number, multitype:number string >
     */
    public function linkToDoc($doc_id,array $file_ids){
        $res = $this->_getResult();
        if(!empty($file_ids)){
            $length = 0;
            $this->startTrans();
            foreach ($file_ids as $id){
                $data = array('id'=>$id,'doc_id'=>$doc_id);
                //若果本来就有,但是再一次更新，应算更新成功
                if($this->save($data)>=0){
                    $length +=1;
                }
            }
            if($length === count($file_ids)){
                $this->commit();
                $res['status'] = 1 ;
            }else{
                $this->rollback();
                $res['msg'] = 'System Error: Batch update error';
            }
        }else{
            //无更新也算成功操作
            $res['status'] = 1 ;
        }
        return $res;
    }
    /**
     *  获得文档文档的附件
     * @param unknown $doc_id 文档id
     * @param string $mime 文档类型
     * @return multitype:number string
     */
    public function getDocFiles($doc_id, $mime = null) {
        $res = $this->_getResult();
        $map['doc_id'] = array('eq',$doc_id);
        if (! empty($mime)) {
            $map['mime'] = array('like','%' . $mime . '%');
        }
        $res['msg'] = $this->where($map)->select();
        if (empty($res['msg'])) {
            $res['msg'] = array();
        }
        $res['status'] = 1;
        return $res;
    }

    /**
     * 删除
     *
     * @param unknown $file_id  附件id        
     */
    public function remove($file_id) {
        $res = $this->_getResult();
        $_result = $this->where("id=%d", $file_id)->select();
        if ($_result) {
            $file =C('UPLOAD_PATH').$_result[0]['save_path'] . $_result[0]['save_name'];
            if (file_exists($file)) {
                unlink($file);
                if ($this->where("id=%d", $file_id)->delete()) {
                    $res['status'] = 1;
                } else {
                    $res['msg'] = "System Error: Not able to delete";
                }
            } else {
                $res['msg'] = 'File not exist!';
            }
        }else{
            $res['msg']  = 'No recored of this file';
        }
        
        return $res;
    }
}

