<?php
namespace Admin\Model;
use Common\Model\MyModel;

class AppModel extends MyModel {
	
	protected $tableName = 'app';
	
	protected $fields = array(0=>'app_id', 1=>'app_name', 2=>'app_title', 3=>'app_author', 4=>'app_admin_entrance',
								5=>'app_type', 6=>'app_admin_layout', 7=>'app_version', 8=>'app_desc', 9=>'ctime', '_pk'=>'app_id');
	protected $pk = 'app_id';
	
	public function getAppsList($limit=20,$map=array()){
		$apps = $this->findPage($limit, false, $map);
		
		if ($apps){
			foreach ($apps['data'] as $k => $v){
				$this->setData($apps['data'][$k]);
			}
		}
		return $apps;
	}
	
	public function setData(&$app){
		$app['friendlydate'] = friendly_date($app['ctime']);
		// TODO set the uninstall operation
		if ($app['app_type'] == 'sys'){
			$app['DOACTION'] = '<a href="'.U('Admin/Admin/unInstallSystemApp', array('name'=>$app['app_name'])).'">'.L('uninstall').'</a>';
		}else {
			$app['DOACTION'] = '<a href="'.U('Admin/Admin/unInstallApp', array('name'=>$app['app_name'])).'">'.L('uninstall').'</a>';
		}
		
		$app['DOACTION'] = $app['DOACTION'].'|<a href="'.U('Admin/Admin/editAppInfo', array('id'=>$app['app_id'])).'">'.L('ADMIN_EDIT').'</a>';
	}
}