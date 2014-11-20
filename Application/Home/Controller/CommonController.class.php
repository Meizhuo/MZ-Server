<?php

namespace Home\Controller;

use Common\Controller\BaseController;
/*
 * 常用接口
 * @author Jayin Ton
 *
 */
class CommonController extends BaseController {
	/**
	 * 生成二维码
	 * @param string $text 二维码内容
	 * @param number $size 二维码长宽,一般为25的倍数,单位：px
	 * @param number $margin 外边距 单位:px
	 */
	public function createQRcode($text = '',$size = 50, $margin = 1){
		vendor('QRcode.phpqrcode');
		\QRcode::png($text,false,QR_ECLEVEL_L,$size/25,$margin);
	}
}


