<?php
namespace Common\Model;
use Common\Model\BaseModel;

/**
 *
 * @author Jayin
 *        
 */
class DocumentModel extends BaseModel {
    /** 审核通过 */
    const VERiFY_PASS = 1;
    /** 审核不通过*/
    const VERIFY_UNPASS = -1;
    /** 等待审核*/
    const VERIFY_WAITING = 0;
    
    protected $_validate = array(
            //插入时必须有:
            array('title','require','缺少标题title',self::MUST_VALIDATE,'',self::MODEL_INSERT),
            array('content','require','缺少内容content',self::MUST_VALIDATE,'',self::MODEL_INSERT),
            array('category_id','require','缺少文档种类category_id',self::MUST_VALIDATE,'',self::MODEL_INSERT),
    );

    protected $_auto = array(
            array('level','31',self::MODEL_INSERT),
            array('create_time',NOW_TIME,self::MODEL_INSERT),
            array('display','1',self::MODEL_INSERT), //默认可见
            array('status','0',self::MODEL_INSERT), //默认未审核
            array('views','0',self::MODEL_INSERT),
            array('order_num','1',self::MODEL_INSERT)
    );
    /**
     * 根据文档id创建一文档
     * @param unknown $doc_id
     * @return \Common\Model\DocumentModel
     */
    public function createDocumentById($doc_id){
        $res_docs = M('Document')->where("id=%d",$doc_id)->select();
        if($res_docs){
            $this->data($res_docs[0]);
        }
        return $this;
    }
    /**
     * 添加一个文档
     * @param unknown $uid 发布人id
     * @return Ambigous <string, multitype:number string >
     */
    public function addDocument($uid){
        $res = $this->_getResult();
    	if($this->create()){
    	    $this->data['uid'] = $uid;
    	    if($this->add()){
    	        $res['status'] = 1;
    	    }else{
    	        $res['msg'] = 'System Error: Not able to insert';
    	    }
    	}else{
    	    $res['msg'] = $this->getError();
    	}
    	return $res;
    }
    
   /**
    * 更新一文档
    * @param unknown $doc_id 文档id
    * @param unknown $data 更新数据
    * @return Ambigous <string, multitype:number string >
    */
    public function updateDocument($doc_id,$data) {
    	$res = $this->_getResult();
    	$data['id'] = $doc_id;
    	if($this->create($data)){
    	    if(count($this->data) >1){
    	        $this->data['update_time'] = NOW_TIME;
    	        $this->save();
    	        $res['status'] = 1;
    	    }
    	}else{
    	    $res['msg'] = $this->getError();
    	}
    	return $res;
    }

    /**
     * 获取文档详情
     * @param unknown $doc_id 文档的id
     * @return multitype:number string
     */
    public function getDocumentInfo($doc_id) {
        //TODO 返回附件信息
        $res = $this->_getResult();
        $res_docs = M('Document')->where("id=%d",$doc_id)->select();
        if($res_docs){
            $res['status'] =1;
            $res['msg'] = $res_docs[0];
        }else{
            $res['msg'] = "Can't not find this document!";
        }
        return $res;
    	
    }
    /**
    * 审核一文档
    * @param unknown $doc_id 文档id
    * @param number $operate 1为通过审核 0为审核不通过 默认为1
    */
    public function verify($doc_id,$operate=self::VERiFY_PASS){
    	$data = array();
    	$data['id'] = $doc_id ;
    	$data['status'] = $operate;
    	return $this->updateDocument($data);
    }
    
    public function hasPermission(){
    	
    }
    
}

