<?php
namespace Zdl\Model;
use Common\Model\MyModel;

class TypeModel extends MyModel {
	protected $tableName = 'type';
	protected $fields    = array(0=>'ty_id', 1=>'ty_name', 2=>'ty_code', 3=>'createdAt', 4=>'updatedAt');
	protected $pk        = 'ty_id';
	
	public function getTypeList($limit=20, $map=array()){
		$listData = $this->where($map)->findPage($limit);
		foreach($listData['data'] as $k => $v){
			$this->_dealData($listData['data'][$k]);
		}
		return $listData;
	}
	
	private function _dealData(&$data){
		$data['DOACTION'] == '<a href="javascript:void(0);" onclick="zdl.delType('.$data['ty_id'].');">'.L(ADMIN_DEL).'</a>';
		$data['DOACTION'] .= '|<a href="'.U('Zdl/Admin/editType', array('id'=>$data['ty_id'],'tabHash'=>'editType')).'">'.L(ADMIN_EDIT).'</a>';
	}
	
	public function getTypeKV($type){
		$datas = $this->select();
		$map = array();
		foreach($datas as $k){
			$map[$k['ty_code']] = $k['ty_name']; 
		}
		return $map;
	}
}