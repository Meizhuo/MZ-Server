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
        $user_admin = M('User')->where($map)->select();
        $user_admin_info = $this->where($map)->select();
        if($user_admin && $user_admin_info){
            $this->data = array_merge($user_admin[0],$user_admin_info[0]);
        }else{
            return null;
        }
        return $this;
    }
    
    public function register(){
    
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
}
