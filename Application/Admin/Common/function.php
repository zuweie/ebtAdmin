<?php

function install_app($app_name){
	
	$app_install = APP_PATH.$app_name.'/Appinfo/install.php';

	if(is_file($app_install)){
		include $app_install;
	}else{
		return false;
	}
}

function uninstall_app($app_name) {
	$app_uninstall = APP_PATH.$app_name.'/Appinfo/uninstall.php';
	
	if(is_file($app_uninstall)){
		include $app_uninstall;
	}else{
		return false;
	}
}

function regist_app($app_name) {
	
	$app_info = APP_PATH.$app_name.'/Appinfo/info.php';
	
	if (is_file($app_info)){
		$info = include $app_info;
		
		if (isset($info['name'])){
			$data['app_name'] = $info['name'];
		}
			
		if (isset($info['author'])){
			$data['app_author'] = $info['author'];
		}
			
		if (isset($info['version'])){
			$data['app_version'] = $info['version'];
		}
		
		if (isset($info['desc'])){
			$data['app_desc'] = $info['desc'];
		}
		
		if (isset($info['admin_entrance'])){
			$data['app_admin_entrance'] = $info['admin_entrance'];
		}
		
		$data['ctime'] = time();
		
		$res = D('Admin/App')->add($data);
		
		return $res;
	}else{
		return false;
	}
}

function unregist_app($app_name) {
	$map['app_name'] = array('EQ', $app_name);
	$res = D('Admin/App')->where($map)->delete();
	return $res;
}

function get_app_info($app_name){
	$app_info = APP_PATH.$aap_name.'/Appinfo/info.php';
	$info = include $app_info;
	return $info;
}

function is_app_installed($app_name){
	$map['app_name'] = array('EQ',  $app_name);
	$res = D('Admin/App')->where($map)->select();
	if (!$res){
		return false;
	}else{
		return true;
	}
}

function get_installed_app(){
	
}

function get_uninstall_app(){
	
}