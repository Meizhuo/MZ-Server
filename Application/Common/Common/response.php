<?php
/**
 * 封装(处理)错误的json格式
 * @param string $msg 提示信息  默认 'operate error'
 * @return multitype:number string
 */
function mz_json_error($msg='operate error'){
    return array('code'=> 500,'msg'=>$msg);
}

/**
 * 封装处理成功的json格式
 * @param string $msg 提示信息 默认 'operate success'
 * @return multitype:number string
 */
function mz_json_success($msg="operate success"){
    return array('code'=> 200,'msg'=>$msg);
}