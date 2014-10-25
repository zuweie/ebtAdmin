<?php
namespace Admin\Controller;
use Common\Controller\MyController;

class PublicController extends MyController {
	
	//public $header = array();
	//public $leftMenu = array();
	//public $iframe   = '';
	
	public function index(){
		
		// push the login user
		$user = get_login_user();
		$this->assign('user', $user);
		
		// $widgets = C('plugins');
		// $this->assign('plugins', $widgets);
		
		// $plugin = I('get.plugin');
		// $this->assign('plugin', $plugin);
		
		$currApp = I('get.currApp', null);
		
		// make the headed index 
		$apps = D('Admin/App')->select();
		foreach ($apps as $k => $v){
			if (($v['app_admin_layout'] & 0x2) !== 0){
				$header[] = array('title'=>$v['app_title'], 'id'=>$v['app_name'], 'name'=>$v['app_name'], 'url'=>$v['app_admin_entrance']);
			}
			
			if (isset($currApp) && $currApp == $v['app_name']){
				$iframe = $v['app_admin_entrance'];
			}
		}
		$this->assign('header', $header);
		$this->assign('iframe', $iframe);
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