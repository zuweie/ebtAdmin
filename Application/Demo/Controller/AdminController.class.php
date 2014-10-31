<?php
namespace Demo\Controller;
use Admin\Controller\AdministratorController;
use Admin\Controller\LeftMenuInterface;
class AdminController extends AdministratorController 
					   implements LeftMenuInterface{
						
	public function leftMenu() {
		
		$leftMenu['title'] = 'Demo';
		$leftMenu['id']    = 'demo';
		$leftMenu['submenu'][] = array('title'=>'Demo列表','id'=>'1', 'url'=>U('Demo/Admin/index'));
		echo json_encode($leftMenu);
		exit;
	}
	
	public function index () {
		
		$this->pageTab[] = array('title'=>'Demo列表', 'tabHash'=>'index', 'url'=>U('Demo/Admin/index'));
		$this->pageTab[] = array('title'=>'增加Demo', 'tabHash'=>'addDemo', 'url'=>U('Demo/Admin/addDemo'));
		
		$listData = D('Demo/Demo')->getDemoList(20);
		$this->pageKeyList = array('demo_id', 'title', 'img', 'file', 'text', 'DOACTION');
		$this->displayList($listData);
	}
	
	public function addDemo() {
		$this->pageTab[] = array('title'=>'Demo列表', 'tabHash'=>'index', 'url'=>U('Demo/Admin/index'));
		$this->pageTab[] = array('title'=>'增加Demo', 'tabHash'=>'addDemo', 'url'=>U('Demo/Admin/addDemo'));
		
		$this->pageKeyList = array('title', 'img', 'file', 'text');
		$this->savePostUrl = U('Demo/Admin/doAddDemo');
		$this->displayConfig();
	}
	
	public function doAddDemo () {
		$data['title'] = I('post.title', null);
		$data['img']   = I('post.img', null);
		$data['file']  = I('post.file_ids', null);
		$data['text']  = I('post.text', null);
		
		$res = D('Demo/Demo')->add($data);
		
		if(!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), U('Demo/Admin/index'));
		}
	}
	
	public function editDemo () {
		
		$id = I('get.id');
		$this->pageTab[] = array('title'=>'Demo列表', 'tabHash'=>'index', 'url'=>U('Demo/Admin/index'));
		$this->pageTab[] = array('title'=>'编辑Demo', 'tabHash'=>'editDemo', 'url'=>U('Demo/Admin/editDemo', array('id'=>$id)));
		
		$this->pageKeyList = array('demo_id', 'title', 'img', 'file', 'text');
		
		$demo = D('Demo/Demo')->find($id);
		
		$this->savePostUrl = U('Demo/Admin/doEditDemo');
		$this->displayConfig($demo);
	}
	
	public function doEditDemo () {
		
		$id = I('post.demo_id');
		
		$data['title'] = I('post.title', null);
		$data['img']   = I('post.img', null);
		$data['file']  = I('post.file_ids', null);
		$data['text']  = I('post.text', null);
		$data['demo_id'] = $id;
		
		$res = D('Demo/Demo')->save($data);
		
		if (!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), u('Demo/Admin/index', array('tabHash'=>'index')));
		}
	}
	
	public function delDemo () {
		$id = I('post.id');
		$res = D('Demo/Demo')->delete($id);
		if (!$res){
			$this->ajaxReturnJson(0, L('ERR_DEL_FAIL'));
		}else{
			$this->ajaxReturnJson(1, L('MSG_DEL_SUCCESS'));
		}
	}
}