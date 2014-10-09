<?php
namespace Common\Model;

use Think\Upload;
/**
 * 文档附件模型
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
     * @param unknown $doc_id 对应的文档id
     * @param unknown $file_info 上传后的文档信息
     * @return Ambigous <string, multitype:number string >
     */
    public function post($doc_id,$file_info) {
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
                //返回附件插入后的信息
                $upload_file = $this->where("save_path='%s' AND save_name='%s'",$file_info['savepath'],$file_info['savename'])->select();
                $res['msg'] = $upload_file[0];
            } else {
                $res['msg'] = 'System Error: Not able to insert.';
            }
        } else {
            $res['msg'] = $this->getError();
        }
        return $res;
    }
}

