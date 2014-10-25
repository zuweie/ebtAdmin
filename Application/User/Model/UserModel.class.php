<?php
namespace User\Model;
use Common\Model\MyModel;

class UserModel extends MyModel {
	
	protected $tableName = 'user';
	
	protected $fields = array(0=>'uid', 1=>'nickname', 2=>'login', 3=>'password', 4=>'user_group', 
								5=>'privilege', 6=>'status', 7=>'ctime', '_pk'=>'uid');
	protected $pk     = 'uid';
	
	public function getLoginUser($login, $pass){
		$map['login'] = array('EQ', $login);
		$map['password'] = array('EQ', $pass);
		$res = $this->where($map)->find();
		if($res){
			unset($map);
			$map['uid'] = array('EQ', $res['uid']);
			$privilege = D('User/UserPrivilege')->field('`privilege`.privilege')->join('LEFT JOIN `privilege` ON `user_privilege`.privilege = `privilege`.pid')->where($map)->select();
			$ps = array();
			foreach($privilege as $p => $v){
				$this->_setPrivilege($v['privilege'], $ps);
			}
			$res['privilege'] = $ps;
			
			unset($map);
			$map['gid'] = array('EQ', $res['user_group']);
			$group_privilege = D('User/GroupPrivilege')->field('`privilege`.privilege')->join('LEFT JOIN `privilege` ON `group_privilege`.privilege = `privilege`.pid')->where($map)->select();
			$gps = array();
			foreach ($group_privilege as $p => $v){
				$this->_setPrivilege($v['privilege'], $gps);
			}
			$res['group_privilege'] = $gps;
		}
		return $res;
	}
	
	public function getUserList($limit=20, $map=array()){
		$list = $this->findPage($limit, false, $map);
		
		foreach($list['data'] as $k => $v){
			$this->setData(&$list['data'][$k]);
		}
		return $list;
	}
	
	public function setData($user){
		$user['friendlydate'] = friendly_date($user['ctime']);
		$user['DOACTION'] = '<a href="'.U('User/Admin/editUser', array('id'=>$user['uid'],'tabHash'=>'editUser')).'">'.L('ADMIN_EDIT').'</a>';
		$user['DOACTION'] .= '|<a href="javascript:void(0);" onclick="user.del('.$user['uid'].')">'.L('ADMIN_DEL').'</a>';
		$user['DOACTION'] .= '|<a href="'.U('User/Admin/userPrivilege', array('uid'=>$user['uid'], 'tabHash'=>'userPrivilege')).'">'.L('ADMIN_USER_PRIVILEGE').'</a>';
	}
	
	private function _setPrivilege($pstring, &$pp){
		$ps = split(';', $pstring);
		foreach( $ps as $p){
			$ep = split(':', $p);
			if (isset($pp[$ep[0]])){
				$pp[$ep[0]] = $pp[$ep[0]] | intval($ep[1]);
			}else{
				$pp[$ep[0]] = intval($ep[1]);
			}
		}
	}
}