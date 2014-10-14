<?php
namespace User\Controller;
use Common\Controller\MyController;

class LoginController extends MyController {
	
	public function login(){
		$this->assign('redirect_to', I('get.redirect_to', null));
		$this->display();
		
	}
	
	public function doLogin() {
		$login = I('post.login');
		$pass  = md5(I('post.password'));
		$rdto  = I('post.redirect_to');
		
		$res = login($login, $pass);
		
		if (!$res){
			$this->error(L('err_login_fail'), U('User/Login/login', array('redirect_to'=>$rdto)));
		}else{
			
			if (!isset($rdto) || $rdto == ''){
				// if no url jump to home page.
				$rdto = U('Home/Index/index');
			}else{
				$rdto = urldecode($rdto);
			}
			$this->success(L('login_success'), $rdto);
		}
	}
	
	public function logout(){
		logout();
		$this->success(L('logout_success'), U('Home/Index/index'));
	}
}