<?php
namespace Demo\Model;
use Common\Model\MyModel;

class DemoModel extends MyModel {
	
	protected $tableName = 'demo';
	protected $fields    = array(0=>'demo_id', 1=>'title', 2=>'img', 3=>'file', 4=>'text');
	protected $pk        = 'demo_id';
	
	public function getDemoList ($limit=20, $map=array()){
		
		$listData = $this->where($map)->findPage($limit);
		foreach($listData['data'] as $k => $v){
			$listData['data'][$k]['DOACTION'] = '<a href="javascript:void(0); onclick="demo.delDemo('.$v['demo_id'].');">删除</a>';
			$listData['data'][$k]['DOACTION'] .= '|<a href="'.U('Demo/Admin/editDemo', array('id'=>$v['demo_id'],'tabHash'=>'editDemo')).'">编辑</a>';
		}
		return $listData;
		
	}
	
	
}