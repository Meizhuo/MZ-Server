<?php
namespace Common\Model;
use Common\Model\BaseModel;

/**
 * 管理员模型
 * @author Jayin
 *        
 */
class UserAdminModel extends BaseModel {
    
    /**
     * 创建Admin对象
     * @param unknown $uid
     * @return \Common\Model\AdminModel 当找不到该用户是返回 NULL
     */
    public function createAdminById($uid){
        $map['uid'] = $uid;
        $user_admin = M('User')->field('psw',true)->where($map)->select();
        $user_admin_info = $this->where($map)->select();
        if($user_admin && $user_admin_info){
        	$user_admin_info[0]['per_categorys_post'] = json_decode($user_admin_info[0]['per_categorys_post']);
        	$user_admin_info[0]['per_categorys_check']= json_decode($user_admin_info[0]['per_categorys_check']);
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
    public function createAdmin($nickname,$phone,$email,$psw,$per_categorys_post,$per_categorys_check,$per_institution_check,$per_person_man,$per_employer_man){
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
        $data['per_person_man'] =$per_person_man;
        $data['per_employer_man'] = $per_employer_man;
        $User = M('User');
        if($User->create($data)){
            //md5
            $User->data['reg_time'] = NOW_TIME;
            $User->data['psw'] =  md5($psw);
            $User->data['level'] = UserModel::LEVEL_ADMIN;
            $User->data['status'] = UserModel::STATUS_PASS;
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

    /**
     * 修改管理员 by wharry
      *@param int admin_id
     * @param JSON $per_categorys_post '有权限起草/编辑的栏目 (JSON)
     * @param JSON $per_categorys_check 有权限管理的群组(JSON) 
     * @param int $per_institution_check 有无权限审核培训机构(0无权限1有权限)
     * @param int $per_person_man 有无权限管理个人用户(0无权限1有权限)
     * @param int $per_employer_man 有无权限管理单位用户(0无权限1有权限)
     * @param int $status 当前管理员用户状态(1正常-2锁定)
     * @return Ambigous <string, multitype:number string >
     */
    public function updateAdmin($admin_id,$per_categorys_post,
 $per_categorys_check,$per_institution_check,
    $per_person_man,$per_employer_man,$status){
        $res = $this->_getResult();
        $data['uid'] = $admin_id;
        $data['per_categorys_post'] = $per_categorys_post;
        $data['per_categorys_check'] = $per_categorys_check;
        $data['per_institution_check'] = $per_institution_check;
        $data['per_person_man'] =$per_person_man;
        $data['per_employer_man'] = $per_employer_man;
        if($this->create($data)){
            // 除了uid还有更新其他项,那么更新，不然会报SQL错误
            if(count($this->data)>1){
                $this->save();
                M('User')->where("uid='%s' AND level=%d",$admin_id,UserModel::LEVEL_ADMIN)->save(array('status'=>$status));
                $res['status'] = 1; 
            }
        }else{
            $res['msg'] = $this->getError();
        }
        return $res;
    }

    /**
     * 验证一用户
     * @param int $admin_id
     * @param int $op 	1:正常(审核通过) 0未审核 -1审核不通过 -2:冻结
     * @return Ambigous <number, string>
     */
    public function vertify($admin_id,$op){
        $res = $this->_getResult();
        $data['status'] = $op;
        $user_admin =M('User');
        if($user_admin->where("uid='%s' AND level=%d",$admin_id,UserModel::LEVEL_ADMIN)->save($data)>=0){
        	$res['status'] = 1;
        }else{
        	$res['msg'] = $user_admin->getError();
        }
        
        return $res;
    }
    /**
     * 获得管理员的信息
     * @param int $uid
     */
    public function info($uid){
        $res = $this->_getResult();
        $info_user = M('User')->field('psw',true)->where("uid='%s'",$uid)->limit(1)->select();
    
        if($info_user){
            $info_admin = $this->field('uid',true)->where("uid='%s'",$uid)->limit(1)->select();
          
            $res['msg'] = array_merge($info_user[0],$info_admin[0]);
            $res['status']  = 1;
        }else{
            $res['msg'] = "admin not found";
        }
        return $res;
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
     * @return boolean  true if it has permission
     */
    public function hasPerCheckInstitution(){
        return $this->status == UserModel::STATUS_PASS && $this->data['per_institution_check'];
    }
    
    /**
     * 是否对给定的栏目(id)有发布的权限
     * @param int $category_id 栏目id
     * @return boolean true if it has permission
     */
    public function hasPerPost($category_id){
        return $this->status == UserModel::STATUS_PASS && in_array($category_id,$this->per_categorys_post);
    }
    /**
     * 是否对给定的栏目(id)有发布的权限
     * @param unknown $category_id
     * @return boolean  true if it has permission
     */
    public function hasPerCheck($category_id){
        return $this->status == UserModel::STATUS_PASS && in_array($category_id,$this->per_categorys_check);
    }
    /**
     * 是否有管理个人用户的权限
     * @return boolean  true if it has permission
     */
    public function hasPerPersonMan(){
    	return $this->status == UserModel::STATUS_PASS && $this->per_person_man == 1;
    }
    /**
     * 是否有管理单位用户(企业)的权限
     * @return boolean true if it has permission
     */
    public function hasPerEmployerMan(){
    	return $this->status == UserModel::STATUS_PASS && $this->per_employer_man ==1;
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
           $map['status'] = array('eq',$status);
       }
       if(!is_null($nickname)){
           $map['nickname'] = array('like','%'.$nickname.'%');
       }
       $map['level'] = array('eq',UserModel::LEVEL_ADMIN);
       // 保证为正数
       $limit = $limit > 0 ? $limit : 10;
       $page = $page > 0 ? $page : 1;
       $res['msg'] = $this->join('mz_user ON mz_user.uid = mz_user_admin.uid')->where($map)
                          ->field('mz_user.uid,nickname,phone,email,reg_time,level,status,per_categorys_post,per_categorys_check,per_institution_check,per_person_man,per_employer_man')
                          ->limit(($page - 1) * $limit, $limit)
                          ->select();
       if(empty($res['msg'])){
           $res['msg'] = array();
       }
       $res['status'] = 1;
       return $res;
    }
}
