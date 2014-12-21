<?php
namespace Propose\Controller;
use Admin\Controller\AdministratorController;
use Admin\Controller\LeftMenuInterface;

class AdminController extends AdministratorController
					   implements LeftMenuInterface {
	
	public function leftMenu() {
		$leftMenu['title'] = '求婚节奏';
		$leftMenu['id']    = 'weddinginvitation';
		$leftMenu['submenu'][] = array('title'=>'配置', 'id'=>'1', 'url'=>U('Propose/Admin/config'));
		echo json_encode($leftMenu);
		exit;
	}

	public function config () {
		$this->pageTab[] = array('title'=>'求婚配置', 'tableHash'=>'config', 'url'=>'#');
		$this->pageKeyList = array('cover', 'pic1', 'pic2', 'pic3',  'pic4', 'pic5', 'pic6', 'music', 'wxcover', 'wxtitle', 'wxcontent', 'pagetitle');
		$config = D('Admin/SystemData')->get('propose:config');
		$this->savePostUrl = U('Propose/Admin/doSaveConfig');
		$this->displayConfig($config);
	}
	
	public function doSaveConfig () {
		

		$data['cover'] = $this->_takeVal(I('post.cover_ids'));
		$data['pic4'] = $this->_takeVal(I('post.pic4_ids'));
		$data['pic1'] = $this->_takeVal(I('post.pic1_ids'));
		$data['pic2'] = $this->_takeVal(I('post.pic2_ids'));
		$data['pic3'] = $this->_takeVal(I('post.pic3_ids'));
		$data['pic5'] = $this->_takeVal(I('post.pic5_ids'));
		$data['pic6'] = $this->_takeVal(I('post.pic6_ids'));
		$data['music'] = $this->_takeVal(I('post.music_ids'));
		$data['wxcover'] = $this->_takeVal(I('post.wxcover_ids'));
		$data['wxtitle'] = I('post.wxtitle', null);
		$data['wxcontent'] = I('post.wxcontent', null);
		$data['pagetitle'] = I('post.pagetitle', null);
		
		$res = D('Admin/SystemData')->put('propose:config', $data);
		
		if (!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), U('Propose/Admin/config'));
		}
	}
	
	private function _takeVal($val){
		if (!empty($val)){
			$vals = explode('|', $val);
			$vals = array_filter($vals);
			return current($vals);
		}else{
			return $val;
		}
	}
}
