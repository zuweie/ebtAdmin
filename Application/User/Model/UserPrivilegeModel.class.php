<?php
namespace User\Model;
use Common\Model\MyModel;

class UserPrivilegeModel extends MyModel {
	protected $tableName = 'user_privilege';
	protected $fields    = array(0=>'up_id', 1=>'uid', 2=>'privilege', '_pk'=>'id');
	protected $pk        = 'up_id';
	
	public function getUserPrivilegeList($uid, $limit=20){
		$map['uid'] = array('EQ', $uid);
		$prefix = C('DB_PREFIX');
		$listData = $this->field('`'.$prefix.'user_privilege`.up_id, `'.$prefix.'user_privilege`.uid as uid, `'.$prefix.'privilege`.pid as pid, `'.$prefix.'privilege`.title as title, `'.$prefix.'privilege`.privilege as privilege')
			 			 ->join('LEFT JOIN `'.$prefix.'privilege` ON `'.$prefix.'user_privilege`.privilege = `'.$prefix.'privilege`.pid')
			 			 ->where($map)->findPage($limit);
		
		foreach ($listData['data'] as $k => $v){
			$listData['data'][$k]['DOACTION'] = '<a href="javascript:void(0);" onclick="user.delUserPrivilege('.$v['up_id'].')">'.L('ADMIN_DEL').'</a>';
		}
		return $listData;
	}
}
