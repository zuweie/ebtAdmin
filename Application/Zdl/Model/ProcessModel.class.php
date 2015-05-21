<?php
namespace Zdl\Model;
use Common\Model\MyModel;

class ProcessModel extends MyModel{
	protected $tableName = 'process';
	protected $fields    = array(0=>'p_id', 1=>'p_title', 2=>'p_context', 3=>'p_maindev', 4=>'p_project', 5=>'p_status', 6=>'p_opened', 7=>'p_closed', 8=>'createdAt', 9=>'updatedAt');
	protected $pk        = 'p_id';
	
	public function getProcessList($limit=20, $map=array()){
		$listData = $this->where($map)->findPage($limit);
		foreach ($listData['data'] as $k => $v){
			$this->_dealData($listData['data'][$k]);
		}
		return $listData;
	}
	
	private function _dealData(&$data){
		if (!empty($data)){
			$maindev = D('Zdl/Dev')->getProcessedMainDev($data['p_id']);
			$data['maindev'] = $maindev['dev_zbh'].' ('.$maindev['dev_id'].')';
			$status = $this->getProcessStatusKV();
			$data['status'] = $status[$data['p_status']];
			$data['DOACTION'] = '<a href="javascript:void(0);" onclick="zdl.delProcess('.$data['p_id'].')">'.L('ADMIN_DEL').'</a>';
			$data['DOACTION'] .='|<a href="'.U('Zdl/Admin/editProcessInfo', array('id'=>$data['p_id'], 'tabHash'=>'editProcessInfo')).'">'.L('ADMIN_ZDL_EDITPROCESSINFO').'</a>';
			$data['DOACTION'] .='|<a href="'.U('Zdl/Admin/editProcessMainDev', array('id'=>$data['p_id'], 'tabHash'=>'editProcessMainDev')).'">'.L('ADMIN_ZDL_EDITPROCESSDEV').'</a>';
		}
	}
	
	public function getProcessById($pid){
		$process = $this->find($pid);
		$this->_dealData($process);
		return $process;
	}
	
	public function getProcessStatusKV(){
		return array(0=>'准备', 1=>'开始', 3=>'暂停', 4=>'结束');
	}
	
	public function removeProjectProcess($project){
		$map['p_project'] = array('EQ', $project);
		$data['p_project'] = -1;
		$res = $this->where($map)->save($data);
		return $res;
	}
}

