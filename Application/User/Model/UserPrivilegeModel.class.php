<?php
namespace User\Model;
use Common\Model\MyModel;

class UserPrivilegeModel extends MyModel {
	protected $tableName = 'user_privilege';
	protected $fields    = array(0=>'id', 1=>'uid', 2=>'privilege');
	
	public function getUserPrivilegeList($uid, $limit=20){
		$map['uid'] = array('EQ', $uid);
		$listData = $this->field('`user_privilege`.uid as uid, `privilege`.pid as pid, `privilege`.title as title, `privilege`.privilege as privilege')
			 			 ->join('LEFT JOIN `privilege` ON `user_privilege`.privilege = `privilege`.pid')
			 			 ->where($map)->findPage($limit);
		
		foreach ($listData['data'] as $k => $v){
			$listData['data'][$k]['DOACTION'] = '<a href="'.U('User/Admin/editPrivilege', array('id'=>$v['pid'], 'tabHash'=>'editPrivilege')).'">'.L('ADMIN_EDIT').'</a>';
		}
		return $listData;
	}
}
