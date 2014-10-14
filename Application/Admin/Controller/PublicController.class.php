<?php
namespace Admin\Controller;
use Common\Controller\MyController;

class PublicController extends MyController {
	public function index(){
		// push the login user
		$user = get_login_user();
		$this->assign('user', $user);
		
		$widgets = C('plugins');
		$this->assign('plugins', $widgets);
		
		$plugin = I('get.plugin');
		$this->assign('plugin', $plugin);
		
		
		$this->display();
	}
	
	public function pluginAgent(){
		
		$p = I('request.plugin');
		$a = I('request.act');
		
		return W($p.'/'.$a);
	}
	
	public function savePageConfig() {
		$ac = A('Admin/Administrator');
		return $ac->savePageConfig();
	}
	
	public function saveSearchConfig() {
		$ac = A('Admin/Administrator');
		return $ac->saveSearchConfig();
	}
}