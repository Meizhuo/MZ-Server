<?php
namespace Common\Controller;
use Think\Controller;
use Common\Model\UserModel;

/**
 * base controller
 * @author Jayin
 *
 */
class BaseController extends Controller {
	/**
     * 对应控制器下没有方法就会执行该方法
     */
    protected function _empty(){
        $this->ajaxReturn(mz_json_error("No interface for this."));
    }
    
    public function index(){
        $this->ajaxReturn(mz_json_success('Hi'));
    }

    /**
     * 需要POST方法,以及必要的参数
     * 
     * @param array $require_data
     *            POST需要的字段
     * @return \Common\Controller\BaseController
     */
    protected function reqPost(array $require_data = null) {
        if (! IS_POST) {
            $this->ajaxReturn(mz_json_error_request());
        }
        if ($require_data) {
            foreach ($require_data as $key) {
                $_k = I('post.' . $key);
                if (!isset($_k)) {
                    $this->ajaxReturn(mz_json_error("require params: " . $key));
                }
            }
        }
        return $this;
    }

    /**
     * 需要登录
     * @return \Common\Controller\BaseController
     */
    protected function reqLogin(){
        if(!$this->isLogin()){
           $this->ajaxReturn(mz_json_error('Login please'));
        }
        return $this;
    }
    /**
     * 是否已经登录
     * @return boolean
     */
    public function isLogin(){
        if(session('uid')){
            return true;
        }
        return false;
    }
    /**
     * 用户登出，清除相关session
     * 
     * @param string $msg ajax 返回的信息
     */
    public function logout($msg = ''){
        session(null); // 清空当前的session
        if(!empty($msg)){
            $this->ajaxReturn(mz_json_success($msg));
        }
    }
    /**
     * 需要某用户角色
     * @param unknown $level
     * @param unknown $msg
     * @return \Common\Controller\BaseController
     */
    private function reqUser($level,$msg){
        $this->reqLogin();
        $res= M('User')->where("uid='%s'",session('uid'))->limit(1)->select();
        if($res && ((int)$res[0]['level']) === $level){
            return $this;
        }
        $this->ajaxReturn(mz_json_error($res[0]));
    }
    /**
     * 需要企业用户登录
     */
    protected  function reqEmployer(){
        return $this->reqUser(UserModel::LEVEL_EMPLOYER, '需要企业用户权限');
    }
    /**
     * 需要机构用户登录
     */
    protected function reqInstitution(){
    	return $this->reqUser(UserModel::LEVEL_INSTITUTION,'需要机构用户权限');
    }
    /**
     * 需要个人用户登录
     */
    protected function reqPerson(){
        return $this->reqUser(UserModel::LEVEL_PERSON,'需要个人用户权限');
    }
    /**
     * 需要管理员登录
     */
    protected function reqAdmin(){
        return $this->reqUser(UserModel::LEVEL_ADMIN,'需要管理员权限');
    }
    
    /**
     * 需要超级管理员登录
     */
    protected function reqSuperAdmin(){
        return $this->reqUser(UserModel::LEVEL_SUPER_ADMIN,'需要超级管理员权限');
    }
    
}

