<?php
namespace User\Model;
use Common\Model\MyModel;

class GroupPrivilegeModel extends MyModel {
	protected $tablenName = 'group_privilege';
	protected $fields     = array(0=>'gp_id', 1=>'gid', 2=>'privilege');
	protected $pk		   = 'gp_id';
	
	public function getGroupPrivilegeList($gid, $limit=20){
		
		$map['gid'] = array('EQ', $gid);
		$prefix = C('DB_PREFIX');
		$listData = $this->field('`'.$prefix.'group_privilege`.gp_id, `'.$prefix.'group_privilege`.gid as gid, `'.$prefix.'privilege`.pid as pid, `'.$prefix.'privilege`.title as title, `'.$prefix.'privilege`.privilege as privilege')
		                 ->join('LEFT JOIN `'.$prefix.'privilege` ON `'.$prefix.'group_privilege`.privilege = `privilege`.pid')
		                 ->where($map)->findPage($limit);
		
		foreach ($listData['data'] as $k => $v){
			$listData['data'][$k]['DOACTION'] = '<a href="javascript:void(0);" onclick="user.delGroupPrivilege('.$v['gp_id'].')">'.L('ADMIN_DEL').'</a>';
		}
		
		return $listData;
	}
	
}