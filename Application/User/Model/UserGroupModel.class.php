<?php
namespace User\Model;
use Common\Model\MyModel;

class UserGroupModel extends MyModel {
	protected $tableName = 'user_group';
	protected $fields    = array(0=>'gid', 1=>'title', 2=>'uid', 3=>'status', 4=>'ctime', '_pk'=>'gid');
	protected $pk        = 'gid';
	
	public function getUserGroupList ($limit=20, $map=array()){
		
		$listData = $this->where($map)->findPage($limit);
		
		foreach ($listData['data'] as $k => $v){
			$listData['data'][$k]['friendlydate'] = friendly_date($v['ctime']); 
			$listData['data'][$k]['DOACTION'] = '<a href="'.U('User/Admin/editUserGroup', array('id'=>$v['gid'], 'tabHash'=>'editUserGroup')).'">'.L('ADMIN_EDIT').'</a>';
			$listData['data'][$k]['DOACTION'] .= '|<a href="javascript:void(0);" onclick="user.delGroup('.$v['gid'].');" >'.L('ADMIN_DEL').'</a>';
			$listData['data'][$k]['DOACTION'] .= '|<a href="'.U('User/Admin/groupPrivilege', array('gid'=>$v['gid'], 'tabHash'=>'groupPrivilege')).'">'.L('ADMIN_USER_GROUP_PRIVILEGE').'</a>';
		}
		
		return $listData;
	}
}