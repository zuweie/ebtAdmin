<?php
namespace WeddingInvitation\Model;
use Common\Model\MyModel;

class GuestModel extends MyModel {

	protected $tableName = 'guest';
	protected $fields = array(0=>'guest_id', 1=>'name', 2=>'title', 3=>'people', 4=>'uid', 5=>'desc', 6=>'status', 7=>'ctime', '_pk'=>'guest_id');
	protected $pk     = 'guest_id';

	public function getGuestList($limit=20, $map=array()) {

		$listData = $this->where($map)->findPage($limit);
		
		foreach ($listData['data'] as $k => $v){
			if ($v['title'] == 'mr'){
				$title = '先生';
			}else if ($v['title'] = 'miss'){
				$title = '女士';
			}else if ($v['title'] == 'couple'){
				$title = '伉俪';
			}
			$listData['data'][$k]['link'] = '<a href="'.U('WeddingInvitation/Index/index', array('name'=>urlencode($v['name']), 'title'=>urlencode($title))).'">'.U('WeddingInvitation/Index/index', array('name'=>urlencode($v['name']), 'title'=>urlencode($title))).'</a>';
			$listData['data'][$k]['DOACTION'] = '<a href="'.U('WeddingInvitation/Admin/editGuest', array('id'=>$v['guest_id'], 'tabHash'=>'editGuest')).'">编辑</a>';
			$listData['data'][$k]['DOACTION'] .= '|<a href="javascript:void(0);" onclick="wd.delGuest('.$v['guest_id'].')">删除</a>';
		}
		
		return $listData;
	}
}