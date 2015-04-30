<?php
namespace Zdl\Model;
use Common\Model\MyModel;

class DevModel extends MyModel{
	protected $tableName = 'dev';
	protected $fields    = array(0=>'dev_id', 1=>'dev_name', 2=>'dev_zbh', 3=>'dev_bah', 4=>'dev_cch', 5=>'dev_attr', 6=>'dev_type', 7=>'dev_process', 8=>'dev_mainbody', 9=>'createdAt', 10=>'updatedAt');
	protected $pk        = 'dev_id';
	
	public function getDevList($limit=20, $map=array()){
		$listData = $this->where($map)->findPage($limit);
		$typekv = $this->getDevType();
		foreach ($listData['data'] as $k => $v){
			$this->_dealData($listData['data'][$k],$typekv);
		}
		return $listData;
	}
	
	private function _dealData (&$dev, $kv){
		$attr = unserialize($dev['dev_attr']);
		$dev['specification'] = $attr['specification'];
		$dev['model']         = $attr['model'];
		$dev['brand']         = $attr['brand'];
		$dev['type']          = $kv[$dev['dev_type']];
		$dev['mainbody']      = ($dev['dev_mainbody'] == 1) ? '是' : '否';
		$dev['DOACTION'] = '<a href="javascript:void(0);" onclick="zdl.delDev('.$dev['dev_id'].');">'.L('ADMIN_DEL').'</a>';
		$dev['DOACTION'] .= '|<a href="'.U('Zdl/Admin/editDev', array('id'=>$dev['dev_id'],'tabHash'=>'editDev')).'">'.L('ADMIN_EDIT').'</a>';
	}
	
	public function getDevType () {
		return array(1=>'塔吊', 2=>'施工梯', 3=>'井架');
	}
	
	public function getIdleMainDev(){
		$map['dev_process'] = array('EQ', -1);
		$map['dev_mainbody'] = array('EQ', 1);
		
		$devs = $this->where($map)->select();
		return $devs;
	}
	
	public function getIdleMainDevKV(){
		$dev = $this->getIdleMainDev();
		$kv;
		foreach($dev as $k){
			$kv[$k['dev_id']] = $k['dev_zbh'].'('.$k['dev_id'].')';
		}
		return $kv;
	}
	
	public function getProcessedMainDev($process){
		$map['dev_process'] = array('EQ', $process);
		$map['dev_mainbody'] = array('EQ', 1);
		$dev = $this->where($map)->find();
		return $dev;
	}
	
	public function getProcessDevs($process){
		$map['dev_process'] = array('EQ', $process);
		$devs = $this->where($map)->select();
		return $devs;
	}
	
	public function removeProcessDev($process){
		$map['dev_process'] = array('EQ', $process);
		$data['dev_process'] = -1;
		$res = $this->where($map)->save($data);
		return $res;
	}
	
	public function isProcessMainDevValid($devid, $process){
		$map['dev_process'] = array('EQ', -1);
		$map['dev_id'] = array('EQ', $devid);
		
		$dev = $this->where($map)->find();
		
		if (!empty($dev)){
			return true;
		}else if (!empty($process) && !empty($dev) && $dev['dev_process'] == $process){
			return true;
		}else{
			return false;
		}
	}
}