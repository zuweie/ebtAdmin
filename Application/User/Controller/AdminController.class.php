<?php
namespace User\Controller;
//use Common\Controller\MyController;
use Admin\Controller\AdministratorController;


class AdminController extends AdministratorController {
	
	public function index (){
		
		$listData = D('User')->getUserList(20);
		$this->pageKeyList = array('uid', 'login', 'password', 'nickname', 'status', 'friendlydate', 'DOACTION');
		$this->pageTab[] = array('title'=>L('ADMIN_USER_INDEX'), 'tabHash'=>'index', 'url'=>U('User/Admin/index'));
		$this->pageTab[] = array('title'=>L('ADMIN_ADD_USER'), 'tabHash'=>'addUser', 'url'=>U('User/Admin/addUser'));
		$this->pageTab[] = array('title'=>L('ADMIN_USER_PRIVILEGE'), 'tabHash'=>'privilege', 'url'=>U('User/Admin/privilege'));
		$this->displayList($listData);
	}
	
	public function editUser() {
		
		$id = I('get.id');
		$user = D('User')->find($id);
		
		$this->pageTab[]   = array('title'=>L('ADMIN_USER_INDEX'), 'tabHash'=>'index', 'url'=>U('User/Admin/index'));
		$this->pageTab[]   = array('title'=>L('ADMIN_EDIT_USER'), 'tabHash'=>'editUser', 'url'=>U('User/Admin/editUser'));
		
		$this->pageKeyList = array('uid', 'login', 'password', 'nickname', 'status');
		$this->savePostUrl = U('User/Admin/doEditUser');
		$this->displayConfig($user);
	}
	
	public function doEditUser() {
		
		$id = I('post.id');
		if (!is_null(I('post.nickname', null))){
			$data['nickname'] = I('post.nickname');
		}
		
		if (!is_null(I('post.status', null))){
			$data['status'] = I('post.status');
		}
		
		if (!is_null(I('post.login', null))){
			$data['login'] = I('post.login'); 
		}
		
		if (!is_null(I('post.password', null))){
			$data['password'] = md5(I('post.password'));
		}
		
		$data['uid'] = $id;
		
		$res = D('User')->save($data);
		
		if(!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), u('User/Admin/index'));
		}
	}
	
	public function addUser(){
		
		$this->pageKeyList = array('login', 'password', 'nickname');
		$this->pageTab[] = array('title'=>L('ADMIN_USER_INDEX'), 'tabHash'=>'index', 'url'=>U('User/Admin/index'));
		$this->pageTab[] = array('title'=>L('ADMIN_ADD_USER'), 'tabHash'=>'addUser', 'url'=>U('User/Admin/addUser'));
		$this->savePostUrl = U('User/Admin/doAddUser');
		$this->displayConfig();
	}
	
	public function doAddUser(){
		
		if (!is_null(I('post.login', null))){
			$data['login'] = tt(I('post.login'));
		}
		
		if(!is_null(I('post.password', null))){
			$data['password'] = md5(tt(I('post.password')));
		}
		
		if(!is_null(I('post.nickname', null))){
			$data['nickname'] = tt(I('post.nickname'));
		}
		
		$data['ctime'] = time();
		
		$res = D('User/User')->add($data);
		
		if (!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), U('User/Admin/index'));
		}
		
	}
	
	public function delUser(){
		
		if(!is_null(I('post.id'))){
			$uid = I('post.id');
			
			$res = D('User/User')->delete($uid);
			
			if(!$res){
				$ret['status'] = 0;
				$ret['data']   = L('ERR_DEL_FAIL');
			}else{
				
				// delete its privilege record
				
				$map['uid'] = array('EQ', $uid);
				D('User/UserPrivilege')->where($map)->delete();
				
				$ret['status'] = 1;
				$ret['data']   = L('MSG_DEL_SUCCESS');
			}
		}else{
			$ret['status'] = 0;
			$res['data'] = L('ERR_DEL_FAIL');
		}
		echo json_encode($ret);
		exit();
	}
	
	public function privilege() {
		if (!is_null(I('get.uid', null))){
			$uid = intval(I('get.uid'));
			$listData = D('User/UserPrivilege')->getUserPrivilegeList($uid);
		}else{
			$listData = D('User/Privilege')->getPrivilegeList(20);
		}
		$this->pageKeyList = array('uid', 'pid', 'title', 'privilege', 'DOACTION');
		$this->pageTab[]   = array('title'=>L('ADMIN_USER_INDEX'), 'tabHash'=>'index', 'url'=>U('User/Admin/index'));
		$this->pageTab[]   = array('title'=>L('ADMIN_USER_PRIVILEGE'), 'tabHash'=>'privilege', 'url'=>('User/Admin/privilege'));
		$this->displayList($listData);
	}
	
	/*
	public function addUserPrivilege (){
		
	}
	*/
	
	public function editPrivilege () {
		
		$this->pageTab[]   = array('title'=>L('ADMIN_USER_INDEX'), 'tabHash'=>'index', 'url'=>U('User/Admin/index'));
		$this->pageTab[]   = array('title'=>L('ADMIN_USER_PRIVILEGE'), 'tabHash'=>'privilege', 'url'=>('User/Admin/privilege'));
		$this->pageTab[]   = array('title'=>L('ADMIN_EDIT_PRIVILEGE'), 'tabHash'=>'editPrivilege', 'url'=>('User/Admin/editPrivilege'));
		
		$id = intval(I('get.id'));
		
		$privilege = D('Privilege')->find($id);
		
		$this->pageKeyList = array('pid', 'title', 'privilege');
		$this->savePostUrl = U('User/Admin/doEditPrivilege');		
		$this->displayConfig($privilege);
		
	}
	
	public function doEditPrivilege () {
		
		if (!is_null(I('post.pid', null))){
			$pid = I('post.pid');
			
			if(!is_null(I('post.title', null))){
				$data['title'] = I('post.title');
			}
			
			if(!is_null(I('post.privilege', null))){
				$data['privilege'] = I('post.privilege');
			}
			
			$data['pid'] = $pid;
			
			$res = D('User/Privilege')->save($data);
			
			if (!$res){
				$this->error(L('ERR_SAVE_FAIL'));
			}else{
				$this->success(L('MSG_SAVE_SUCCESS'), U('User/Admin/privilege'));
			}
		}else{
			$this->error(L('ERR_SAVE_FAIL'));
		}
	}
}