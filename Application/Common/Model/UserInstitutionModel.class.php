<?php
namespace Common\Model;
use Common\Model\BaseModel;
use Common\Model\UserModel;
/**
 * 机构模型
 * @author Jayin
 *
 */
class UserInstitutionModel extends BaseModel {

    protected $_validate = array();
    
    protected $_auto = array();
    
    public function createInsById($uid){
        $map['uid'] = $uid;
        $user_ins = M('User')->field('psw',true)->where($map)->select();
        $user_ins_info = $this->where($map)->select();
        if($user_ins && $user_ins_info){
            $this->data = array_merge($user_ins[0],$user_ins_info[0]);
        }else {
            return null;
        }
        return $this;
    }
    
    /**
     * 添加一个培训机构用户
     * @param unknown $data
     * @return Ambigous <string, multitype:number string >
     */
    public function addInstitution($data){
        $res = $this->_getResult();
        if($this->create($data)){
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
     * 更新机构信息
     * NOTE: 这里不能更新机构的status,即UserModel那里
     * @param unknown $data
     * @return Ambigous <string, multitype:number string >
     */
    public function updateInfo($data){
        $res = $this->_getResult();
        if($this->create($data)){
            //机构描述采用html格式
            $this->data['description'] = I('post.description','','');
            // 除了uid还有更新其他项,那么更新，不然会报SQL错误
            if(count($this->data)>1){
                $this->save();
                $res['status'] = 1; 
            }
        }else{
            $res['msg'] = $this->getError();
        }
        return $res;
    }
    
    /**
     * 审核一机构
     * @param unknown $doc_id 文档id
     * @param number $operate 1为通过审核 0为审核不通过 默认为1
     */
    public function verify($institution_id,$operate=UserModel::STATUS_PASS){
        $res = $this->_getResult();
        $data['status'] = $operate;
        $user_ins =M('User'); 
        if($user_ins->where("uid='%s' AND level=%d",$institution_id,UserModel::LEVEL_INSTITUTION)->save($data)>=0){
            $res['status'] = 1;
        }else{
            $res['msg'] = $user_ins->getError();
        }
        return $res;
    }
    
    /**
     * 模糊查询 
     * @param unknown $status 机构状态
     * @param unknown $name 机构名称
     * @param unknown $type 机构类别 
     * @param number $page 页码 默认1
     * @param number $limit 返回数 默认10
     * @return unknown
     */
    public function search($status='', $name='', $type='', $page = 1, $limit = 10) {
        $res = $this->_getResult();
        $map = array();
        $map['level'] = UserModel::LEVEL_INSTITUTION;
        if (! empty($status)) {
            $map['status'] = $status;
        }
        if (! empty($name)) {
            $map['name'] = array('like','%' . $name . '%' );
        }
        if (! empty($type)) {
            $map['type'] = array('like','%' . $type . '%');
        }
        // 保证为正数
        $limit = $limit > 0 ? $limit : 10;
        $page = $page > 0 ? $page : 1;
        $users_ins = M('User')->join('mz_user_institution ON mz_user.uid = mz_user_institution.uid')->where($map)
            ->field( 'mz_user_institution.uid,nickname,phone,email,reg_time,level,status,name,address,type,description,manager,contact_member,contact_phone,contact_email')
            ->limit(($page - 1) * $limit, $limit)
            ->select();
        if(!$users_ins){
            $res['msg'] = array();
        }else{
            $res['msg'] = $users_ins;
        }
        $res['status'] = 1;
        return $res;
    }
}
 