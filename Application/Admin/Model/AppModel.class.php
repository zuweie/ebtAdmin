<?php
namespace Admin\Model;
use Common\Model\MyModel;

class AppModel extends MyModel {
	
	protected $tableName = 'app';
	
	protected $fields = array(0=>'app_id', 1=>'app_name', 2=>'app_author', 3=>'app_admin_entrance',
								4=>'app_version', 5=>'app_desc', 6=>'ctime', '_pk'=>'app_id');
	protected $pk = 'app_id';
	
	public function getAppsList($limit=20,$map=array()){
		$apps = $this->findPage($limit, false, $map);
		
		if ($apps){
			foreach ($apps['data'] as $k => $v){
				$this->setData(&$apps['data'][$k]);
			}
		}
		return $apps;
	}
	
	public function setData($app){
		$app['friendlydate'] = friendly_date($app['ctime']);
		$app['DOACTION'] = '<a href="'.U('Admin/Public/pluginAgent', array('plugin'=>'AppManager', 'act'=>'doUnInstallApp', 'name'=>$app['app_name'])).'">'.L('uninstall').'</a>';
	}
}