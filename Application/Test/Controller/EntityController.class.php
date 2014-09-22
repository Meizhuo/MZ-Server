<?php
namespace Test\Controller;
use Think\Controller;

class EntityController extends Controller {

    public function index(){
        $this->display();
    }
    
    public function add(){
       \Think\Log::record(json_encode($_POST));
     
       
      $project = M("subsidy_standary");
      $project->create();
      if($project->add()){
          $this->ajaxReturn(array('status'=>'200'));
      }else{
          $this->ajaxReturn(array('status'=>'500'));
          
      }
      // \Think\Log::record(json_encode($project));
    }
    
    
}

