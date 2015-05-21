<?php
namespace Zdl\Model;
use Common\Model\MyModel;

class TaskModel extends MyModel {
	protected $tableName = 'task';
	protected $fields    = array(0=>'t_id', 1=>'t_title', 2=>'t_creater', 3=>'t_userid', 4=>'t_usergroup', 5=>'t_type', 6=>'t_request', 7=>'t_response',
								8=>'t_attention', 9=>'t_attach', 10=>'t_process', 11=>'t_dev', 12=>'t_date', 13=>'t_open', 14=>'t_close', 15=>'t_expct_close',
								16=>'t_act_sql', 17=>'t_status', 18=>'createAt', 19=>'updatedAt');
	protected $pk        = 't_id';
	
	private function __dealData(&$data){
		$data['friendly_date'] = friendly_date($data['t_date']);
		$data['doaction'] = '<a href="'.U('Zdl/Zdl/addRepairationRecord', array('pid'=>$data['t_process'], 'tid'=>$data['t_id'])).'">编辑</a>';
		$data['doaction'] .= '| <a href="'.U('Zdl/Zdl/delRepairationRecord', array('pid'=>$data['t_process'], 'tid'=>$data['t_id'])).'">删除</a>';
	}
	
	public function getTaskList($limit=20, $map=array()){
		$listData = $this->where($map)->order('t_date desc')->findPage($limit);
		foreach($listData['data'] as $k => $v){
			$this->__dealData($listData['data'][$k]);
		}
		return $listData;
	}
	
	public function getTaskByProcessId($pid){
		$map['t_process'] = array('EQ', $pid);
		$listData = $this->getTaskList(20, $map);
		return $listData;
	}
}