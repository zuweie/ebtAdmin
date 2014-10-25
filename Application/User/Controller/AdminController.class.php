<?php
namespace User\Controller;

use Admin\Controller\AdministratorController;
use Admin\Controller\LeftMenuInterface;
use User\Model\UserPrivilegeModel;

class AdminController extends AdministratorController 
					   implements LeftMenuInterface{
	
	public function index (){
	
		$listData = D('User')->getUserList(20);
		$this->pageKeyList = array('uid', 'login', 'password', 'nickname', 'user_group', 'status', 'friendlydate', 'DOACTION');
		$this->pageTab[] = array('title'=>L('ADMIN_USER_INDEX'), 'tabHash'=>'index', 'url'=>U('User/Admin/index'));
		$this->pageTab[] = array('title'=>L('ADMIN_ADD_USER'), 'tabHash'=>'addUser', 'url'=>U('User/Admin/addUser'));
		//$this->pageTab[] = array('title'=>L('ADMIN_USER_PRIVILEGE'), 'tabHash'=>'privilege', 'url'=>U('User/Admin/privilege'));
		$this->displayList($listData);
	}
	
	public function leftMenu() {
		$leftMenu['title'] = L('menu_title');
		$leftMenu['id'] = 'user';
		$leftMenu['submenu'] = array(
			array('title'=>L('ADMIN_USER_INDEX'), 'id'=>'1', 'url'=>U('User/Admin/index')),
			array('title'=>L('ADMIN_USER_GROUP_INDEX'), 'id'=>'2', 'url'=>U('User/Admin/userGroup')),
			array('title'=>L('ADMIN_PRIVILEGE_SETTING'), 'id'=>'3', 'url'=>U('User/Admin/privilege'))
			//array('title'=>L('ADMIN_USER_GROUP_PRIVILEGE'), 'id'=>'4', 'url'=>U('User/Admin/groupPrivilege'))
		);
		
		echo json_encode($leftMenu);
		exit;
	}
	
	public function editUser() {
		
		$id = I('get.id');
		$user = D('User')->find($id);
		
		$this->pageTab[]   = array('title'=>L('ADMIN_USER_INDEX'), 'tabHash'=>'index', 'url'=>U('User/Admin/index'));
		$this->pageTab[]   = array('title'=>L('ADMIN_EDIT_USER'), 'tabHash'=>'editUser', 'url'=>U('User/Admin/editUser'));
		
		$this->pageKeyList = array('uid', 'nickname', 'user_group','status');
		$this->savePostUrl = U('User/Admin/doEditUser');
		$this->displayConfig($user);
	}
	
	public function doEditUser() {
		
		$id = I('post.uid');
		if (!is_null(I('post.nickname', null))){
			$data['nickname'] = I('post.nickname');
		}
		
		if (!is_null(I('post.status', null))){
			$data['status'] = I('post.status');
		}
		
		if (!is_null(I('post.user_group', null))){
			$data['user_group'] = intval(I('post.user_group'));
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
				$this->ajaxReturn(0, L('ERR_DEL_FAIL'));
			}else{
				
				// delete its privilege record
				
				$map['uid'] = array('EQ', $uid);
				D('User/UserPrivilege')->where($map)->delete();
				
				$this->ajaxReturn(1, L('MSG_DEL_SUCCESS'));
			}
		}else{
			$this->ajaxReturn(0, L('ERR_DEL_FAIL'));
		}
		
	}
	
	public function userGroup () {
		$listData = D('User/UserGroup')->getUserGroupList();
		$this->pageTab[] = array('title'=>L('ADMIN_USER_GROUP_INDEX'), 'tabHash'=>'userGroup', 'url'=>U('User/Admin/UserGroup'));
		$this->pageTab[] = array('title'=>L('ADMIN_ADD_USER_GROUP'), 'tabHash'=>'addUserGroup', 'url'=>U('User/Admin/addUserGroup'));
		$this->pageKeyList = array('gid', 'title', 'status', 'friendlydate', 'DOACTION');
		$this->displayList($listData);
	}
	
	public function addUserGroup () {
		$this->pageTab[] = array('title'=>L('ADMIN_USER_GROUP_INDEX'), 'tabHash'=>'userGroup', 'url'=>U('User/Admin/UserGroup'));
		$this->pageTab[] = array('title'=>L('ADMIN_ADD_USER_GROUP'), 'tabHash'=>'addUserGroup', 'url'=>U('User/Admin/addUserGroup'));
		$this->pageKeyList = array('title', 'status');
		$this->savePostUrl = U('User/Admin/doAddUserGroup');
		$this->displayConfig();
	}
	
	public function doAddUserGroup () {
		
		if (!is_null(I('post.title', null))){
			$data['title'] = tt(I('post.title'));
		}
		
		if (!is_null(I('post.status', null))){
			$data['status'] = intval(I('post.status'));
		}
		
		$data['ctime'] = time();
		
		$res = D('User/UserGroup')->add($data);
		
		if (!$res) {
			$this->error(L('ERR_SAVE_FAIL'));
		}else {
			$this->success(L('MSG_SAVE_SUCCESS'), U('User/Admin/UserGroup'));
		}
	}
	
	public function editUserGroup () {
		$this->pageTab[] = array('title'=>L('ADMIN_USER_GROUP_INDEX'), 'tabHash'=>'userGroup', 'url'=>U('User/Admin/UserGroup'));
		$this->pageTab[] = array('title'=>L('ADMIN_EDIT_USER_GROUP'), 'tabHash'=>'editUserGroup', 'url'=>U('User/Admin/editUserGroup'));
		
		$this->pageKeyList = array('gid', 'title', 'status');
		
		$id = intval(I('get.id'));
		$g  = D('User/UserGroup')->find($id);
		$this->savePostUrl = U('User/Admin/doEditUserGroup');
		$this->displayConfig($g);
	}
	
	public function doEditUserGroup () {
		
		if (!is_null(I('post.title', null))){
			$data['title'] = tt(I('post.title'));
		}
		
		if (!is_null(I('post.status', null))){
			$data['status'] = intval(I('post.status'));
		}
		
		$data['gid'] = intval(I('post.gid'));
		
		
		$res = D('User/UserGroup')->save($data);
		
		if (!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), U('User/Admin/userGroup'));
		}
	}
	
	public function userPrivilege () {
		
		$uid = intval(I('get.uid'));
		
		$this->pageTab[] = array ('title'=>L('ADMIN_USER_INDEX'), 'tabHash'=>'index', 'url'=>U('User/Admin/index'));
		$this->pageTab[] = array ('title'=>L('ADMIN_USER_PRIVILEGE_LIST'), 'tabHash'=>'userPrivilege', 'url'=>U('User/Admin/userPrivilege'));
		$this->pageTab[] = array ('title'=>L('ADMIN_ADD_USER_PRIVILEGE'), 'tabHash'=>'addUserPrivilege', 'url'=>U('User/Admin/addUserPrivilege', array('uid'=>$uid)));
		
		
		$listData = D('User/UserPrivilege')->getUserPrivilegeList($uid);
		$this->pageKeyList = array ('uid', 'pid', 'title', 'privilege', 'DOACTION');
		$this->displayList($listData);
		
	}
	
	public function addUserPrivilege () {
		$this->pageTab[] = array('title'=>L('ADMIN_USER_INDEX'), 'tabHash'=>'index', 'url'=>U('User/Admin/index'));
		$this->pageTab[] = array('title'=>L('ADMIN_ADD_USER_PRIVILEGE'), 'tabHash'=>'addUserPrivilege', 'url'=>U('User/Admin/addUserPrivilege'));
		$uid = intval(I('get.uid'));
		
		$up['uid'] = $uid;
		$this->pageKeyList = array('uid', 'privilege');
		$this->savePostUrl = U('User/Admin/doAddUserPrivilege');
		$this->displayConfig($up);
	}
	
	public function doAddUserPrivilege () {
		$uid = intval(I('post.uid'));
		$pid = intval(I('post.privilege'));
		if ($uid !== 0 && $pid !== 0){
			$data['uid'] = $uid;
			$data['privilege'] = $pid;
			
			$res = D('User/UserPrivilege')->add($data);
			
			if (!$res) {
				$this->error(L('ERR_SAVE_FAIL'));	
			}else{
				$this->success(L('MSG_SAVE_SUCCESS'), U('User/Admin/userPrivilege', array('tabHash'=>'userPrivilege', 'uid'=>$uid)));
			}
		}else{
			$this->error(L('ERR_SAVE_FAIL'));
		}
	}
	
	
	public function delUserPrivilege () {
		$upid = intval(I('post.upid'));
		
		$res = D('User/UserPrivilege')->delete($upid);
		
		if(!$res){
			$this->ajaxReturn(0, L('ERR_DEL_FAIL'));
		}else{
			$this->ajaxReturn(1, L('MSG_DEL_SUCCESS'));
		}
	}
	
	public function groupPrivilege () {
		$gid = intval(I('get.gid',0));
		$this->pageKeyList = array('gp_id', 'gid', 'pid','title','privilege', 'DOACTION');
		$this->pageTab[] = array('title'=>L('ADMIN_USER_GROUP_PRIVILEGE'), 'tabHash'=>'groupPrivilege', 'url'=>U('User/Admin/GroupPrivilege', array('gid'=>$gid)));
		$this->pageTab[] = array('title'=>L('ADMIN_ADD_USER_GROUP_PRIVILEGE'),'tabHash'=>'addGroupPrivilege', 'url'=>U('User/Admin/addGroupPrivilege', array('gid'=>$gid)));	
		
		$listData = D('User/GroupPrivilege')->getGroupPrivilegeList($gid);
		$this->displayList($listData);
	}
	
	public function addGroupPrivilege () {
		$gid = intval(I('get.gid'));
		
		$this->pageTab[] = array('title'=>L('ADMIN_USER_GROUP_PRIVILEGE'), 'tabHash'=>'groupPrivilege', 'url'=>U('User/Admin/GroupPrivilege', array('gid'=>$gid)));
		$this->pageTab[] = array('title'=>L('ADMIN_ADD_USER_GROUP_PRIVILEGE'),'tabHash'=>'addGroupPrivilege', 'url'=>U('User/Admin/addGroupPrivilege', array('gid'=>$gid)));
		$gp['gid'] = $gid;
		$this->pageKeyList = array('gid', 'privilege');
		$this->savePostUrl = U('User/Admin/doAddGroupPrivilege');
		$this->displayconfig($gp);
	}
	
	public function doAddGroupPrivilege () {
		
		$gid = I('post.gid', 0);
		$pid = I('post.privilege', 0);
		
		if ($gid != 0 && $pid !=0){
			$data['gid'] = $gid;
			$data['privilege'] = $pid;
			
			$res = D('User/GroupPrivilege')->add($data);
			if (!$res){
				$this->error(L('ERR_SAVE_FAIL'));
			}else{
				$this->success(L('MSG_SAVE_SUCCESS'), U('User/Admin/groupPrivilege', array('gid'=>$gid)));
			}
		}else{
			$this->error(L('ERR_SAVE_FAIL'));
		}
		
	}
	
	public function delGroupPrivilege () {
		$id = intval(I('post.id'));
		$res = D('User/GroupPrivilege')->delete($id);
		
		if (!$res){
			$this->ajaxReturn(0, L('ERR_DEL_FAIL'));
		}else{
			$this->ajaxReturn(1, L('MSG_DEL_SUCCESS'));
		}
	}
	
	public function privilege() {

		$listData = D('User/Privilege')->getPrivilegeList(20);
		$this->pageKeyList = array('pid', 'title', 'privilege', 'DOACTION');
		$this->pageTab[]   = array('title'=>L('ADMIN_PRIVILEGE_LIST'), 'tabHash'=>'privilege', 'url'=>U('User/Admin/privilege'));
		$this->pageTab[]   = array('title'=>L('ADMIN_PRIVILEGE_ADD'), 'tabHash'=>'addPrivilege', 'url'=>U('User/Admin/addPrivilege'));
		$this->displayList($listData);
	}
	
	
	public function addPrivilege (){
		$this->pageKeyList = array('title', 'privilege');
		$this->pageTab[]   = array('title'=>L('ADMIN_PRIVILEGE_LIST'), 'tabHash'=>'privilege', 'url'=>U('User/Admin/privilege'));
		$this->pageTab[]   = array('title'=>L('ADMIN_PRIVILEGE_ADD'), 'tabHash'=>'addPrivilege', 'url'=>U('User/Admin/addPrivilege'));
		$this->savePostUrl = U('User/Admin/doAddPrivilege');
		$this->displayConfig();
	}
	
	public function doAddPrivilege () {
		if (!is_null(I('post.title', null))){
			$data['title'] = tt(I('post.title'));
		}
		
		if (!is_null('post.privilege', null)){
			$data['privilege'] = tt(I('post.privilege'));
		}
		
		$res = D('User/Privilege')->add($data);
		
		if (!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), U('User/Admin/privilege'));
		}
	}
	
	public function editPrivilege () {
		
		$this->pageTab[]   = array('title'=>L('ADMIN_PRIVILEGE_LIST'), 'tabHash'=>'privilege', 'url'=>U('User/Admin/privilege'));
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
	
	public function delPrivilege () {
		$pid = intval(I('post.id'));
		$res = D('User/Privilege')->delete($pid);
		
		if (!$res){
			$this->ajaxReturn(0, L('ERR_DEL_FAIL'));
		}else{
			
			// TODO : delete the user privilege.
			$map['privilege'] = array('EQ', $pid);
			D('User/UserPrivilege')->where($map)->delete();
			
			// TODO : delete the group privilege.
			D('User/GroupPrivilege')->where($map)->delete();
			
			$this->ajaxReturn(1, L('MSG_DEL_SUCCESS'));
		}
	}
}