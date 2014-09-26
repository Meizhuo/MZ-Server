<?php
namespace Home\Controller;
use Think\Controller;

class UserController extends Controller {
    
    public function index(){
        $user  = D('User');
        $user->lol();
    }
    
    public function addUser(){
        $User = D('User');
        if($User->add()){
            $this->ajaxReturn(mz_json_success());
        }else{
            $this->ajaxReturn(mz_json_error($User->getError()));
        }
    }
    
    public function addAdmin(){
        
    }
    
    public function update($uid){
        
    }
    
    public function login(){
        
    }
    
    public function logout(){
        
    }
      
}

