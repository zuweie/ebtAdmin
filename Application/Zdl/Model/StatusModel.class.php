<?php
namespace Zdl\Model;
use Common\Model\MyModel;

class StatusModel extends MyModel {
	protected $tableName = 'status';
	protected $fields    = array(0=>'s_id', 1=>'s_name', 2=>'s_code', 3=>'createdAt', 4=>'updatedAt');
	protected $pk        = 's_id';
	
	public function getStatusList($limit=20, $map=array()) {
		$listData = $this->where($map)->findPage($limit);
		foreach ($listData['data'] as $k => $v){
			$this->_dealData($listData['data'][$k]);
		}
		return $listData;
	}
	
	private function _dealData(&$data){
		$data['DOACTION'] = '<a href="javascript:void(0);" onclick="zdl.delStatus('.$data['s_id'].');">'.L(ADMIN_DEL).'</a>';
		$data['DOACTION'] .= '|<a href="'.U('Zdl/Admin/editStatus', array('id'=>$data['s_id'],'tabHash'=>'editStatus')).'">'.L(ADMIN_EDIT).'</a>';
	}
	
	public function getStatusKV($whatstatus, $vk){
		
		$map = array();
		// 0 到 100 是设备进程状态.
		if ($whatstatus == 'process_status'){
			$map['s_code'] = array(array('EGT', 0), array('lt', 100));
		}
		
		$list = $this->where($map)->select();
		
		$kv;

		foreach($list as $k){
			if ($vk == true){
				$kv[$k['s_name']] = $k['s_code'];
			}else{
				$kv[$k['s_code']] = $k['s_name'];
			}
		}
		return $kv;
	}
	
	
	public function getStatusByCode($code){
		$map['s_code'] = array('EQ', $code);
		$res = $this->where($map)->find();
		return $res;
	}
	
	public function isStatusValid($code, $sid){
		$status = $this->getStatusByCode($code);
		if (!$status){
			return true;
		}else if (!empty($sid) && $status['s_id'] == $sid){
			return true;
		}else{
			return false;
		}
	}
}