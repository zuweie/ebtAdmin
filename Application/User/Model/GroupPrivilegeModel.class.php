<?php
namespace User\Model;
use Common\Model\MyModel;

class GroupPrivilegeModel extends MyModel {
	protected $tablenName = 'group_privilege';
	protected $fields     = array(0=>'gp_id', 1=>'gid', 2=>'privilege');
	protected $pk		   = 'gp_id';
	
	public function getGroupPrivilegeList($gid, $limit=20){
		
		$map['gid'] = array('EQ', $gid);
		
		$listData = $this->field('`group_privilege`.gp_id, `group_privilege`.gid as gid, `privilege`.pid as pid, `privilege`.title as title, `privilege`.privilege as privilege')
		                 ->join('LEFT JOIN `privilege` ON `group_privilege`.privilege = `privilege`.pid')
		                 ->where($map)->findPage($limit);
		
		foreach ($listData['data'] as $k => $v){
			$listData['data'][$k]['DOACTION'] = '<a href="javascript:void(0);" onclick="user.delGroupPrivilege('.$v['gp_id'].')">'.L('ADMIN_DEL').'</a>';
		}
		
		return $listData;
	}
	
}