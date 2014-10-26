<?php
namespace Common\Model;
use Common\Model\BaseModel;

/**
 * 
 * @author Jayin
 *
 */
class UserPersonModel extends BaseModel {
    protected $_validate = array(
        //插入，更新时必须有:
        array('uid','require','缺少uid',self::MUST_VALIDATE),
    	//插入时唯一性验证
    	array('uid','','uid不唯一',self::EXISTS_VALIDATE,'unique',self::MODEL_INSERT),
        array('sex','checkSex','性别为:男或女',self::EXISTS_VALIDATE,'callback',self::MODEL_BOTH)
    );
    
    protected $_auto = array(
    	array('sex','男'),
        array('work_place','')
    );
    /**
     * 检查性别时候符合格式
     * @param unknown $sex
     * @return boolean
     */
    protected function checkSex($sex){
         if($sex === '男' || $sex === '女'){
             return true;
         }
         return false;
    }
    /**
     * 添加一个用户
     * @param unknown $data
     * @return Ambigous <multitype:number string , string>
     */
    public function addPerson($data){
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
     * 更新个人用户信息
     * 
     * @param unknown $data            
     * @return Ambigous <string, multitype:number string >
     */
    public function updateInfo($data) {
        $res = $this->_getResult();
        if ($this->create($data)) {
            if (count($this->data) > 1) {
                $this->save();
                $res['status'] = 1;
            }
        } else {
            $res['msg'] = $this->getError();
        }
        return $res;
    }
    
    public function search($status=null,$nickname=null,$email=null,$work_place=null,$page=1,$limit=10){
        $res = $this->_getResult();
        $map = array();
        $map['level'] =  UserModel::LEVEL_PERSON;
        if(!is_null($status)){
            $map['status']  = $status;
        }
        if(!is_null($nickname)){
            $map['nickname']  = $nickname;
        }
        if(!is_null($email)){
            $map['email']  = $email;
        }
        if(!is_null($work_place)){
            $map['work_place']  = $work_place;
        }
        // 保证为正数
        $limit = $limit > 0 ? $limit : 10;
        $page = $page > 0 ? $page : 1;
        $users_person = M('User')->join('mz_user_person ON mz_user.uid = mz_user_person.uid')
                                 ->where($map)
                                 ->field('mz_user.uid,nickname,phone,email,reg_time,level,status,sex,work_place')
                                 ->limit(($page - 1) * $limit, $limit)
                                 ->select();
        if(!$users_person){
            $res['msg'] = array();
        }else{
            $res['msg'] =$users_person;
        }
        $res['status'] = 1;
        return $res;
    }
   
}

 