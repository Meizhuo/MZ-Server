<?php
namespace Common\Model;
use Common\Model\BaseModel;

/**
 *
 * @author Jayin
 *        
 */
class UserModel extends BaseModel {

    /**
     * 个人用户
     */
    const LEVEL_PERSON = 1;

    /**
     * 用人单位
     */
    const LEVEL_EMPLOYER = 2;

    /**
     * 管理员
     */
    const LEVEL_ADMIN = 4;

    /**
     * 培训机构用户
     */
    const LEVEL_INSTITUTION = 8;

    /**
     * 审核不通过
     */
    const STATUS_UNPASS = - 1;

    /**
     * 未审核
     */
    const STATUS_NOT_VERTIFY = 0;

    /**
     * 审核通过
     */
    const STATUS_PASS = 1;

    protected $_validate = array(
            // array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
            //默认,验证条件：0存在字段就进行验证 , 验证时间：1新增/编辑 数据时候验证
            
            //插入时必须有:
            array('nickname','require','缺少昵称',self::MUST_VALIDATE,'',self::MODEL_INSERT),
            array('psw','require','缺少密码',self::MUST_VALIDATE,'',self::MODEL_INSERT),
            //插入时唯一性验证
            array('nickname','','昵称已存在',self::EXISTS_VALIDATE,'unique',self::MODEL_INSERT),
            array('phone','','手机号码已存在',self::EXISTS_VALIDATE,'unique',self::MODEL_INSERT),
            array('email','','邮箱已存在',self::EXISTS_VALIDATE,'unique',self::MODEL_INSERT),
            //任何时刻,字段存在就进行格式检查
            array('phone','number','手机号码必须为数字'),
            array('phone','11','电话号码长度为11',self::EXISTS_VALIDATE,'length'),
            array('email','email','邮箱格式错误'),
            array('psw','8,16','密码长度8-16,数字+字符',self::EXISTS_VALIDATE,'length')
            
    );
    
    protected $_auto = array(
    	//完成字段1,完成规则,[完成条件,附加规则]
    	array('reg_time',NOW_TIME,self::MODEL_INSERT),
        array('level','1',self::MODEL_INSERT),
        array('status','1',self::MODEL_INSERT)
    );

    /**
     * 注册一个用户
     * @return array() status:1为正常 0为失败 msg:失败信息
     */
    public function regPerson(){
        $res = $this->_getResult();
        if(!$this->create()){
            $res['msg'] = $this->getError();
            return $res;
        }
        $this->data['level']='1';
        $this->data['status']='1';
        $this->data['psw'] = md5($this->data['psw']);
        $uid = $this->add();
        if($uid){
           $_data = array(
           	    'uid' => $uid
           );
           //创建user_person资料
           $user_person = D('UserPerson');
           if($user_person->create(array_merge($_data,I('post.')))){
               if($user_person->add()){
                    $res['status'] =1;
               }else{
                   $res['msg'] = '无法插入 ,系统错误';
               }
           }else{
               return $res['msg'] = $user_person->getError();
           }
        }else{
            $res['msg'] = '无法插入 ,系统错误';
        }
        return $res;
    }
    
    public function regEmployer(){
        
    }
    
    public function regAdmin(){
        
    }
    
    public function regInstitution(){
        
    }
   
    /**
     * 登录
     * @param unknown $account_type 账号(邮箱/手机号码)
     * @param unknown $account
     * @param unknown $psw
     */
    public function login($account_type,$account,$psw){
       $res = $this->_getResult();
       $map['psw'] = $psw;
       if($account_type === 'phone' ){
           $map['phone'] =$account;
       }else{
           $map['email'] =$account;
       }
       $u = $this->where($map)->select();
       if($u){
          $res['status'] = 1;
          $res['msg']  = $u[0];
       }else{
           $res['msg']='密码不对';
       }
       return $res;
    }
    /**
     * 获得一个用户的信息
     * @param unknown $uid 用户id
     */
    public function getUserInfo($uid){
        $res = $this->_getResult();
        $users = $this->field('nickname,phone,email,reg_time,level,status')->where("uid='%s'",$uid)->select();
        if($users){
            $_result = M('UserPerson')->field('sex,work_place')->where("uid='%s'",$uid)->select();
            $res['status'] = 1;
            $res['msg'] = array_merge($users[0],$_result[0]);
        }else{
            $res['msg'] = 'No session info,login please';
        }
        return $res;
    }
    /**
     * 更新用户信息
     * @param unknown $uid
     * @return Ambigous <number, multitype:number string , string>
     */
    public function updateUserInfo($data){
        $res =$this->_getResult();
        print_r($data);
        if($this->create($data)){
            $this->save();
            $person = D('UserPerson');
            if($person->create($data)){
                $person->save();
                $res['status']  = 1;
            }else{
                $res['msg'] = $this->getError();    
            }
        }else{
            $res['msg'] = $this->getError();
        }
        return $res;
    }
}

