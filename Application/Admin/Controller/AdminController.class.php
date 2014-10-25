<?php
namespace Admin\Controller;
use Admin\Controller\AdministratorController;
use Admin\Controller\LeftMenuInterface;

class AdminController extends AdministratorController 
					   implements LeftMenuInterface{

	/**
	 * 列出还未安装的应用
	 */
	public function index() {

		$handle = opendir(APP_PATH);
		$unSetupApps;
		while(false !== ($entry = readdir($handle))){
			if(is_dir(APP_PATH.'/'.$entry.'/Appinfo') && is_file(APP_PATH.'/'.$entry.'/Appinfo/info.php')){
				$info = include APP_PATH.'/'.$entry.'/Appinfo/info.php';
				if(!is_app_installed($info['name'])){
					if ($info['type'] == 'sys'){
						$info['DOACTION'] = '<a href="'.U('Admin/Admin/installSystemApp', array('name'=>$info['name'])).'">'.L('install').'</a>';
					}else{
						$info['DOACTION'] = '<a href="'.U('Admin/Admin/installApp', array('name'=>$info['name'])).'">'.L('install').'</a>';
					}
					$unSetupApps['data'][] = $info;
				}
			}
		}
		closedir($handle);
		if (isset($unSetupApps)){
				
			$this->pageKeyList = array('name', 'title', 'admin_layout',  'admin_entrance', 'type','author', 'version', 'desc', 'DOACTION');

			$this->displayList($unSetupApps);
		}else{
			echo L('msg_no_unseted_apps');
			exit;
		}

	}

	public function dispApps() {


		// find all the installed app
		$data = D('App')->getAppsList(20);

		if (!$data){
			echo L('msg_no_installed_apps');
			exit;
		}else{
			$this->pageKeyList = array('app_id', 'app_name', 'app_title', 'app_author', 'app_type', 'app_admin_layout', 'app_admin_entrance', 'app_version', 'app_desc','friendlydate','DOACTION');
			$this->displayList($data);
		}
	}

	public function editAppInfo () {
		$id = I('get.id', null);
		if (isset($id)){
			$app = D('Admin/App')->find($id);
			$this->pageKeyList = array('app_id' ,'app_title', 'app_author', 'app_admin_layout', 'app_admin_entrance', 'app_version', 'app_desc');
			$this->savePostUrl = U('Admin/Admin/doEditAppInfo');
			$this->displayConfig($app);
		}
	}
	
	public function doEditAppInfo () {
		$id = I('post.app_id', null);
		if (!is_null(I('post.app_title', null))){
			$data['app_title'] = tt(I('post.app_title'));
		}
		
		if (!is_null('post.app_author', null)){
			$data['app_author'] = tt(I('post.app_author'));
		}
		
		if (!is_null('post.app_admin_layout',null)){
			$data['app_admin_layout'] = intval(I('post.app_admin_layout'));
		}
		
		if (!is_null('post.app_admin_entrance', null)){
			$data['app_admin_entrance'] = tt(I('post.app_admin_entrance'));
		}
		
		if (!is_null('post.app_version', null)){
			$data['app_version'] = tt(I('post.app_version'));
		}
		
		if (!is_null('post.app_desc', null)){
			$data['app_desc'] = tt(I('post.app_desc'));
		}
		
		$data['app_id'] = intval(I('post.app_id'));
		
		$res = D('Admin/App')->save($data);
		
		if (!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), U('Admin/Admin/dispApps'));
		}
	}
	
	public function installSystemApp () {
		$name = I('get.name');
		$this->_doInstallApp($name);
	}

	public function unInstallSystemApp () {
		$name = I('get.name');
		$this->_doUnInstallApp($name);
	}

	public function installApp() {
		$name = I('get.name');
		$this->_doInstallApp($name);
	}
	
	public function unInstallApp () {
		$name = I('get.name');
		$this->_doUnInstallApp($name);
	}
	
	private function _doInstallApp ($name) {
		
		if (isset($name) && !is_app_installed($name)){
			$res = install_app($name);
			$res = regist_app($name);
			if ($res){
				$this->success(L('install_app_success'), U('Admin/Admin/dispApps'));
			}else{
				$this->error(L('err_install_app_fail'));
			}
		}
	}

	private function _doUnInstallApp ($name) {
		
		if (isset($name) && is_app_installed($name)){
			
			$res = unregist_app($name);
			uninstall_app($name);
				
			if ($res){
				$this->success(L('msg_uninstall_app_success'), U('Admin/Admin/index'));
			}else{
				$this->error(L('err_uninstall_app_fail'));
			}
		}
	}

	public function leftMenu(){

		$leftMenu['title'] = L('menu_title');
		$leftMenu['id']    = 'admin';
		$leftMenu['submenu'] = array(
				array('title'=>L('submenu_title_uninstalledapp'), 'id'=>1, 'url'=>U('Admin/Admin/index')),
				array('title'=>L('submenu_title_installedapp'), 'id'=>2, 'url'=>U('Admin/Admin/dispApps'))
		);
		$apps = D('Admin/App')->select();
		foreach ($apps as $k => $a){
			if (($a['app_admin_layout'] & 1) != 0){
				$leftMenu['submenu'][] = array('title'=>$a['app_title'], 'id'=>$k+2, 'url'=>$a['app_admin_entrance']);
			}
		}
		
		echo json_encode($leftMenu);
		exit;
	}
}