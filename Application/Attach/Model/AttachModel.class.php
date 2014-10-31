<?php
namespace Attach\Model;
use Common\Model\MyModel;

class AttachModel extends MyModel {
	protected $fields = array(0=>'attach_id', 1=>'ext', 2=>'size', 3=>'name',4=>'savename', 5=>'savepath', 6=>'filepath', 7=>'type', 8=>'md5', 9=>'sha1', 10=>'ctime', '_pk'=>'attach_id');
	protected $tableName = 'attach';
	protected $pk = 'attach_id';
	
	public function getAttachList($limit=20, $map=array()){
		$listData = $this->where($map)->findPage($limit);
		foreach($listData['data'] as $k => $v){
			$listData['data'][$k]['DOACTION'] = '<a href="javascript:void(0);" onclick="attach.del('.$v['attach_id'].');">'.L('ADMIN_DEL').'</a>';
		}
		return $listData;
	}
	
	public function getAttachByIds($aids){
		
		if (is_string($aids)){
			$map['attach_id'] = array('EQ', $adis);
		}else{
			$map['attach_id'] = array('IN', $aids);
		}
		
		$attach = $this->where($map)->select();
		return $attach;
	}
}