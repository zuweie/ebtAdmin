<?php
namespace Attach\Controller;
use Admin\Controller\AdministratorController;
use Admin\Controller\LeftMenuInterface;

class AdminController extends AdministratorController
					   implements LeftMenuInterface{
	
	public function index() {
		$this->pageTab[] = array('title'=>L('ADMIN_ATTACH_INDEX'), 'tabHash'=>'index', 'url'=>U('Attach/Admin/index'));
		$listData = D('Attach/Attach')->getAttachList(20);
		$this->pageKeyList = array('attach_id', 'ext', 'size', 'name', 'filepath', 'md5', 'DOACTION');
		$this->displayList($listData);
	}
	
	public function uploadConfig () {
		//$this->pageTab[] = array('title'=>L('ADMIN_ATTACH_INDEX'), 'tabHash'=>'index', 'url'=>U('Attach/Admin/index'));
		$this->pageTab[] = array('title'=>L('ADMIN_ATTACH_CONFIG'), 'tabHash'=>'config', 'url'=>U('Attach/Admin/uploadConfig'));
		$this->pageKeyList = array('mimes', 'maxSize', 'exts', 'autoSub', 'rootPath', 
									'savePath', 'saveName', 'saveExt', 'replace', 'hash');
		$listkey = 'attach:config';
		$data = D('Admin/SystemData')->get($listkey);
		
		// init the listData
		if (!isset($data['maxSize'])){
			$data['maxSize'] = 0;
		}
		
		if (!isset($data['autoSub'])){
			$data['autoSub'] = true;
		}
		
		if (!isset($data['rootPath'])){
			$data['rootPath'] = './Public/Uploads/';
		}
		
		if (!isset($data['saveName'])){
			$data['saveName'] = 'time';	
		}
		
		if (!isset($data['replace'])){
			$data['replace'] = true;
		}
		
		if (!isset($data['hash'])){
			$data['hash'] = true;
		}
		
		$this->savePostUrl = U('Attach/Admin/doSaveConfig');
		$this->displayConfig($data);
	}
	
	public function doSaveConfig () {
		
		$data['mimes'] = I('post.mimes', '');
		$data['maxSize'] = I('post.maxSize', 0);
		$data['exts'] = I('post.exts', '');
		$data['autoSub'] = I('post.autoSub', true);
		$data['subName'] = I('post.subName', 'time');
		$data['rootPath'] = I('post.rootPath', './Public/Uploads/');
		$data['savePath'] = I('post.savePath', '');
		$data['saveName'] = I('post.saveName', 'uniqid');
		$data['saveExt'] = I('post.saveExt', '');
		$data['replace'] = I('post.replace', true);
		$data['hash'] = I('post.hash', true);
		
		//$val['attach_config'][] = $data;
		$keyval = 'attach:config';
		$res = D('Admin/SystemData')->put($keyval, $data);
		if (!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), U('Attach/Admin/uploadConfig'));
		}
	}
	
	public function leftMenu() {
		$leftMenu['title'] = L('ADMIN_ATTACH_LEFT_MENU_TITLE');
		$leftMenu['id']    = 'attach';
		$leftMenu['submenu'][] = array('title'=>L('ADMIN_ATTACH_CONFIG'), 'id'=>1, 'url'=>U('Attach/Admin/uploadConfig'));
		$leftMenu['submenu'][] = array('title'=>L('ADMIN_ATTACH_INDEX'), 'id'=>2, 'url'=>U('Attach/Admin/index'));
		echo json_encode($leftMenu);
		exit;
 	}
}