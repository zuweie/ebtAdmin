<?php
namespace Common\Controller;
use Think\Controller;

class MyController extends Controller {
	
	public function _initialize() {
		
		// 定义一下必须要的环境变量 原生没有的
		
		define('IS_HTTPS', 0);
		define('SITE_DOMAIN', strip_tags($_SERVER['HTTP_HOST']));
		define('SITE_URL', (IS_HTTPS? 'https:':'http:').'//'.SITE_DOMAIN.'/');
		define('PUBLIC_STATIC', '/Public/static');
		define('MODULE_STATIC', '/Application/'.MODULE_NAME.'/View/_static/');
		
		$this->mid = get_login_user_id();
		$this->assign('uid', $this->mid);
	}
	
	protected $mid = -1;
}