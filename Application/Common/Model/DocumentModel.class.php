<?php
namespace Common\Model;
use Common\Model\BaseModel;

/**
 * 文档模型
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
     * @return Ambigous <string, multitype:number string > 成功插入时返回文档id
     */
    public function addDocument($uid){
        $res = $this->_getResult();
    	if($this->create()){
    	    $this->data['uid'] = $uid;
    	    //文档发布时，默认是等待审核的 
    	    $this->data['status'] = DocumentModel::VERIFY_WAITING;
    	    //内容已经由前端过滤
    	    $this->data['content'] = I('post.content','','');
    	    $uid = $this->add();
    	    if($uid){
    	        $res['status'] = 1;
    	        $res['msg'] = $uid;
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
    	        //更新的时候也不过滤
    	        $this->data['content'] = I('post.content','','');
    	        //更新后应该变为待审核
    	        $this->data['status'] = self::VERIFY_WAITING;
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
     * 
     * @param unknown $doc_id
     *            文档的id
     * @return multitype:number string
     */
    public function getDocumentInfo($doc_id) {
        $res = $this->_getResult();
        $res_docs = M('Document')->where("id='%s'", $doc_id)->select();
        $res_doc_files = D('DocumentFile')->getDocFiles($doc_id)['msg'];
        if ($res_docs) {
            $res['status'] = 1;
            if($res_doc_files){
                $res['msg'] = array_merge($res_docs[0],array('files'=>$res_doc_files));
            }else{
                $res['msg'] = array_merge($res_docs[0],array('files'=>array()));
            }
            
            //浏览量统计
            $viewed_data['views'] = $res_docs[0]['views'] + 1;
            M('Document')->where("id=%d", $doc_id)->save($viewed_data);
        } else {
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
        $res = $this->_getResult();
    	$data = array();
    	$data['id'] = $doc_id ;
    	$data['status'] = $operate;
    	if($this->save($data)>=0){
    	    $res['status'] = 1;
    	}else{
    	    $res['msg'] = 'System Error: not able to update';
    	}
    	return $res;
    }
    
    public function hasPermission(){
    	//TODO 检查权限
    }

    /**
     * 文档查询
     * @param string $category_id
     * @param string $title
     * @param string $content
     * @param string $status
     * @param number $page
     * @param number $limit
     * @return Ambigous <\Think\mixed, boolean, string, NULL, mixed, multitype:, unknown, object>
     */
    public function search($category_id='',$title='',$content='',$status='',$page=1,$limit=10){
        //这里不用返回文档的附件信息了
        $map = array();
        if(!empty($category_id)){
            $map['category_id'] = array('like','%'.$category_id.'%');
        }
        if(!empty($title)){
            $map['title'] = array('like','%'.$title.'%');
        }
        if(!empty($content)){
            $map['content'] = array('like','%'.$content.'%');
        }
        if($status == 0 || !empty($status)){
            $map['status'] = array('eq',$status);
        }
        // 保证为正数
        $limit = $limit > 0 ? $limit : 10;
        $page = $page > 0 ? $page : 1;
        $res['msg']  = $this->where($map)->limit(($page-1)*$limit,$limit)->select();
        if(empty($res['msg'])){
            $res['msg'] = array();
        }
        $res['status'] = 1;
        return $res;
    }
    
}

