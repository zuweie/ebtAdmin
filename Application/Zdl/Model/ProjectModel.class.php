<?php
namespace Zdl\Model;
use Common\Model\MyModel;

class ProjectModel extends MyModel {
	protected $tableName = 'project';
	protected $fields    = array(0=>'pro_id', 1=>'pro_title', 2=>'pro_addr', 3=>'pro_status', 4=>'pro_opened', 5=>'pro_closed', 6=>'createdAt', 7=>'updatedAt');
	protected $pk        = 'pro_id';
	
	public function getProjectList($limit=20, $map=array()){
		$listData = $this->where($map)->findPage($limit);
		foreach($listData['data'] as $k => $v){
			$this->_dealData($listData['data'][$k], $p_s);
		}
		return $listData;
	}
	
	private function _dealData(&$data){
		$data['DOACTION'] = '<a href="'.U('Zdl/Admin/editProject', array('id'=>$data['pro_id'],'tabHash'=>'editProject')).'">'.L('ADMIN_EDIT').'</a>';
		$data['DOACTION'] .= '|<a href="'.U('Zdl/Admin/addProcess', array('pro_id'=>$data['pro_id'], 'pro_title'=>$data['pro_title'], 'tabHash'=>'addProcess')).'">'.L('ADMIN_ZDL_ADDPROCESS').'</a>';
		$data['DOACTION'] .= '|<a href="'.U('Zdl/Admin/process', array('pro_id'=>$data['pro_id'])).'">'.L('ADMIN_ZDL_PROCESS').'</a>';
		$data['DOACTION'] .= '|<a href="javascript:void(0);" onclick="zdl.delProject('.$data['pro_id'].');">'.L('ADMIN_DEL').'</a>';
		$status = $this->getProjectStatus();
		$data['status'] = $status[$data['pro_status']];
	}
	
	public function getProjectStatus() {
		return  array(0=>'准备', 1=>'开始', 3=>'暂停', 4=>'完结');
	}
}