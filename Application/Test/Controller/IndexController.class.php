<?php
namespace Test\Controller;
use Think\Controller;
// use GuzzleHttp\Client;
class IndexController extends Controller {
    public function index(){
    	 vendor('guzzle.GuzzleHttp.Client');
         $client =  new \GuzzleHttp\Client();
         $response = $client->get('http://localhost/mz/home/user/login');
         var_dump($response);
    }
}