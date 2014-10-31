<?php
namespace User\Model;
use Common\Model\MyModel;

class PrivilegeModel extends MyModel {
	
	protected $tableName = 'privilege';
	protected $fields = array(0=>'pid', 1=>'title', 2=>'privilege', '_pk'=>'pid');
	protected $pk = 'pid';
	
	public function getPrivilegeList($limit=20, $map=array()){
		$listData = $this->where($map)->findPage($limit);
		
		foreach($listData['data'] as $k => $v){
			$listData['data'][$k]['DOACTION'] = '<a href="'.U('User/Admin/editPrivilege', array('id'=>$v['pid'], 'tabHash'=>'editPrivilege')).'">'.L('ADMIN_EDIT').'</a>';
			$listData['data'][$k]['DOACTION'] .= '|<a href="javascript:void(0);" onclick="user.delPrivilege('.$v['pid'].')">'.L('ADMIN_DEL').'</a>';
		}
		
		return $listData;
	}
	
	public function getPrivilege($fields=null, $map=array()){
		if(isset($fields)){
			$privilege = $this->field($fields)->where($map)->select();
		}else{
			$privilege = $this->where($map)->select();
		}
		return $privilege;
	}
	
	public function getPrivilegeKV($map=array()){
		$pp = $this->getPrivilege('pid, title', $map);
		$kv = array();
		foreach($pp as $p ){
			$kv[$p['pid']] = $p['title'];
		}
		return $kv;
	}
}