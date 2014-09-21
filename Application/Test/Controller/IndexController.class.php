<?php
namespace Test\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->show('<h1>Test/Index/index</h>');
    }
}