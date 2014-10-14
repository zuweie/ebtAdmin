<?php
namespace Admin\Controller;
use Common\Controller\MyController;

class InstallController extends MyController{
	
	function install(){
		$this->display();
	}
	
	function uninstall(){
		//uninstall_app();
	}
	
	function doInstall(){
		
		// step 1: install the admin database;
		// step 2: install the user App;
		// step 3: redirect the Admin/Index/index;
		
		// check if the Admin app had install
		if (!is_app_installed('Admin')){
			// TODO : install it self first
			$res = install_app('Admin');
			
			//TODO : push the Admin data into Admin
			$res = regist_app('Admin');
			
			$res = install_app('User');
			
			$res = regist_app('User');
			
			$res = $this->_registAdminUser();
			
			// TODO : redirect to the login html
			//exit('Admin install finish');
			$this->success(L('install_app_success'), U('Admin/Public/index'));
		}else{
			exit(L('err_install_app_fail'));
		}
	}
	
	private function _registAdminUser(){
		
		if (isset($_POST['nickname'])){
			$data['nickname'] = $_POST['nickname'];
		}
		
		if (isset($_POST['login'])){
			$data['login'] = $_POST['login'];
		}
		
		if (isset($_POST['pass'])){
			$data['password'] = md5($_POST['pass']);
		}
		
		$data['ctime'] = time();
		
		// 第一次增加用户，为超级管理员用户
		$res = D('User/User')->add($data);
		
		// 为用户添加管理员权限
		if ($res){
			unset($data);
			$data['uid'] = $res;
			$data['privilege'] = 1;
			
			$res = D('User/UserPrivilege')->add($data);
		}
		return $res;
	}
}