<?php
namespace Common\Controller;
use Think\Controller;

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
           $this->ajaxReturn(mz_json_error('login please'));
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
}

