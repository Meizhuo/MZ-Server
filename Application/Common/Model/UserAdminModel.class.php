<?php
namespace Common\Model;
use Common\Model\BaseModel;

/**
 *
 * @author Jayin
 *        
 */
class UserAdminModel extends BaseModel {
    
    /**
     * 创建Admin
     * @param unknown $uid
     * @return \Common\Model\AdminModel 当找不到该用户是返回 NULL
     */
    public function createAdminById($uid){
        $map['uid'] = $uid;
        $user_admin = M('User')->field('psw',true)->where($map)->select();
        $user_admin_info = $this->where($map)->select();
        if($user_admin && $user_admin_info){
            $this->data(array_merge($user_admin[0],$user_admin_info[0]));
        }else{
            return null;
        }
        return $this;
    }
    
    /**
     * 创建管理员
     * @param string $nickname  
     * @param string $phone
     * @param string $email
     * @param string $psw
     * @param JSON $per_categorys_post '有权限起草/编辑的栏目 (JSON)
     * @param JSON $per_categorys_check 有权限管理的群组(JSON) 
     * @param int $per_institution_check 有权限审核培训机构(0无权限1有权限)
     * @return Ambigous <string, multitype:number string >
     */
    public function createAdmin($nickname,$phone,$email,$psw,$per_categorys_post,$per_categorys_check,$per_institution_check){
        $res = $this->_getResult();
        $data['nickname'] = $nickname;
        if(!is_null($phone)){
             $data['phone'] = $phone;
        }
        $data['email'] = $email;
        $data['psw'] = $psw;
        $data['per_categorys_post'] = $per_categorys_post;
        $data['per_categorys_check'] = $per_categorys_check;
        $data['per_institution_check'] = $per_institution_check;
        $data['level'] = UserModel::LEVEL_ADMIN;
        $data['status'] = UserModel::STATUS_PASS;
        $User = D('User');
        if($User->create($data)){
            //md5
            $data['psw'] = md5($psw);
            $uid = $User->add();
            if(!$uid){
                $res['msg'] =  'System Error: Not able to insert.';
                return $res;
            }
        }else{
            $res['msg'] = $User->getError();
            return $res;
        }
        $data['uid'] = $uid;
        if($this->create($data)){
            if($this->add()){
                $res['status'] = 1;
            }else{
                $res['msg'] = 'System Error: Not able to insert.';
            }
        }else{
            $res['msg'] = $this->getError();
        }
        return $res;
    }
            
    public function update(){
         
    }
    
    public function info(){
    
    }
    /**
     * 获取 有权限起草/编辑的栏目 
     * @return mixed array
     */
    public function getPermissionPost(){
        return json_decode($this->data['per_categorys_post']);
    }
    /**
     * 获取有权限管理（审核)的栏目
     * @return mixed array
     */
    public function getPermissionCheck(){
       return json_decode($this->data['per_categorys_check']);
    }
    
    /**
     * 是否有审核机构权限
     * @return multitype:
     */
    public function hasPerCheckInstitution(){
        return $this->data['per_institution_check'];
    }
    
    /**
     * 是否对给定的栏目(id)有发布的权限
     * @param int $category_id 栏目id
     * @return true if it has
     */
    public function hasPerPost($category_id){
        return in_array($category_id,$this->getPermissionPost());
    }
    /**
     * 是否对给定的栏目(id)有发布的权限
     * @param unknown $category_id
     * @return boolean  true if it has
     */
    public function hasPerChckeck($category_id){
        return in_array($category_id,$this->getPermissionCheck());
    }
    /**
     * 管理员列表
     * @param string $status
     * @param unknown $nickname
     * @param unknown $page
     * @param unknown $limit
     */
    public function search($status=null,$nickname=null,$page=1,$limit=10){
       $map = array();
       if(!is_null($status)){
           $map['status'] = $status;
       }
       if(!is_null($nickname)){
           $map['nickname'] = $nickname;
       }
       // 保证为正数
       $limit = $limit > 0 ? $limit : 10;
       $page = $page > 0 ? $page : 1;
       $res['msg'] = $this->join('mz_user ON mz_user.uid = mz_user_admin.uid')->where($map)
                          ->field('mz_user.uid,nickname,phone,email,reg_time,level,status,per_categorys_post,per_categorys_check,per_institution_check')
                          ->limit(($page - 1) * $limit, $limit)
                          ->select();
       if(empty($res['msg'])){
           $res['msg'] = array();
       }
       $res['status'] = 1;
       return $res;
    }
}
