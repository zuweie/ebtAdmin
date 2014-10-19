<?php
namespace Admin\Widget;
use Admin\Widget\AdminBaseWidget;

class AppManagerWidget extends AdminBaseWidget {
	
	public function getMenu(){
		$menu['title'] = '应用管理';
		$menu['id'] = 'AppManager';
		$menu['submenu'] = array(
			array('id'=>'1','title'=>'未安装应用', 'url'=>U('Admin/Public/pluginAgent', array('plugin'=>'AppManager','act'=>'dispUnApps'))),
			array('id'=>'2','title'=>'已经安装应用', 'url'=>U('Admin/Public/pluginAgent', array('plugin'=>'AppManager','act'=>'dispApps')))
		);
		$apps = D('App')->select();
		foreach($apps as $k => $v){
			$menu['submenu'][] = array('id'=>$k+3, 'title'=>$v['app_name'], 'url'=>U($v['app_admin_entrance']));
		}
		return $menu;
	}
	
	public function dispApps(){
		
		// find all the installed app
		$data = D('App')->getAppsList(20);
		
		if (!$data){
			echo L('msg_no_installed_apps');
			exit;
		}else{
			$ac = A('Admin/Administrator');
			$ac->pageKeyList = array('app_id', 'app_name', 'app_author', 'app_admin_entrance', 'app_version', 'app_desc','friendlydate','DOACTION');
			//$ac->searchKey = array('app_name');
			//$ac->searchPostUrl = U('Admin/Public/pluginAgent', array('plugin'=>'AppManager', 'act'=>'dispApps'));
			$ac->pageButton[] = array('title'=>'搜索','onclick'=>"admin.fold('search_form')");

			return $ac->displayList($data);
		}
	}
	
	public function dispUnApps(){
		
		$handle = opendir(APP_PATH);
		$unSetupApps;
		while(false !== ($entry = readdir($handle))){
			if(is_dir(APP_PATH.'/'.$entry.'/Appinfo') && is_file(APP_PATH.'/'.$entry.'/Appinfo/info.php')){
				$info = include APP_PATH.'/'.$entry.'/Appinfo/info.php';
				if(!is_app_installed($info['name'])){
					$info['DOACTION'] = '<a href="'.U('Admin/Public/pluginAgent', array('plugin'=>'AppManager', 'act'=>'doInstallApp', 'name'=>$info['name'])).'">'.L('install').'</a>';
					$unSetupApps['data'][] = $info;
				}
			}
		}
		closedir($handle);
		if (isset($unSetupApps)){
			
			$ac = A('Admin/Administrator');
			$ac->pageKeyList = array('name', 'author', 'version', 'desc', 'DOACTION');
			
			return $ac->displayList($unSetupApps);
		}else{
			echo L('msg_no_unseted_apps');
			exit;
		}
	}
	
	public function doInstallApp(){
		$name = I('get.name', null);
		$usr_privilege = get_login_privilege();
		
		if (!verify_static_privilege($usr_privilege, array('app'=>0x2))){
			$this->error(L('err_app_write_prvilege'));
		}
		
		if(isset($name) && !is_app_installed($name)){
			$res = install_app($name);
			$res = regist_app($name);
			if ($res){
				$this->success(L('install_app_success'), U('Admin/Public/pluginAgent', array('plugin'=>'AppManager', 'act'=>'dispApps')));
			}
		}else{
			$this->error(L('err_install_app_fail'));
		}
	}
	
	public function doUnInstallApp(){
		$name = I('get.name', null);
		
		$usr_privilege = get_login_privilege();
		
		if (!verify_static_privilege($usr_privilege, array('app'=>0x3))){
			$this->error(L('err_app_write_prvilege'));
		}
		
		if (isset($name) && is_app_installed($name)){
			
			$res = unregist_app($name);
			uninstall_app($name);
			
			
			if ($res){
				$this->success(L('msg_uninstall_app_success'), U('Admin/Public/pluginAgent', array('plugin'=>'AppManager', 'act'=>'dispApps')));
			}else{
				$this->error(L('err_uninstall_app_fail'));
			}
		}
	}
	
}