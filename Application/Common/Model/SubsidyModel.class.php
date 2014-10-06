<?php
namespace Common\Model;

/**
 * 补贴项目模型
 * @author Jayin
 *
 */
class SubsidyModel extends BaseModel {
    //映射到指定的表
    protected $tableName = 'subsidy_standary';

    protected $_validate = array(
    	array('money','number','金额必须是数字')
    );
    /**
     * 发布补贴项目
     * @return Ambigous <multitype:number string , string>
     */
    public function post(){
        $res = $this->_getResult();
        if($this->create()){
            if($this->add()){
                $res['status']=1;
            }else{
                $res['msg'] =  'System error: Not able to insert';
            }
        }else{
            $res['msg'] = $this->getError();
        }
        return $res;
    }

    /**
     * 更新补贴项目
     * 
     * @return Ambigous <multitype:number string , string>
     */
    public function update() {
        $res = $this->_getResult();
        if ($this->create()) {
            // 只有id，但是没有更新项，直接忽略
            if (count($this->data) === 1 || $this->save() >= 0) {
                $res['status'] = 1;
            } else {
                $res['msg'] = 'System error: Not able to update';
            }
        } else {
            $res['msg'] = $this->getError();
        }
        return $res;
    }
    /**
     * 删除
     * @param unknown $id 项目id
     * @return Ambigous <number, multitype:number string , string>
     */
    public function remove($id) {
        $res = $this->_getResult();
        if ($this->where("id=%d", $id)->delete()) {
            $res['status'] = 1;
        } else {
            $res['msg'] = $this->getError();
        }
        
        return $res;
    }
    /**
     * 模糊搜索项目
     * @param unknown $certificate_type
     * @param unknown $kind
     * @param unknown $level
     * @param unknown $series
     * @param unknown $title
     * @param number $page
     * @param number $limt
     * @return multitype:number string
     */
    public function search($certificate_type ,$kind,$level,$series,$title,$page=1,$limit=10){
        $res = $this->_getResult();
        $map = array();
        if(!empty($certificate_type)){
            $map['certificate_type'] = array('like','%'.$certificate_type.'%');
        }
        if(!empty($kind)){
            $map['kind'] = array('like','%'.$kind.'%');
        }
        if(!empty($level)){
            $map['level'] = array('like','%'.$level.'%');
        }
        if(!empty($series)){
            $map['series'] = array('like','%'.$series.'%');
        }
        if(!empty($title)){
            $map['title'] = array('like','%'.$title.'%');
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
    /**
     * 获取每一个字段的种类
     * 
     * @param unknown $field
     * @return json String [{"fieldName":"xxx"}.....]
     * 
     */
    public function getSigleFieldType($field){
        $res = $this->_getResult();
        $res['msg'] = $this->field($field)->distinct(true)->select();
        if(empty($res['msg'])){
            $res['msg'] = array();
        }
        $res['status'] =1;
        return $res;
    }
}
 