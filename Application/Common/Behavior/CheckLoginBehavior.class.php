<?php
namespace Common\Behavior;

class CheckLoginBehavior{
	
	public function run(&$param){
		$acc = C('access_ctrl');
		if ($acc){
			$acl = C('access');
			
			if ($acl[MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME] === 0){
				// access = array( m/c/a => 0) : redirect
				if (!is_login()){
					redirect(U('User/Login/login', array('redirect_to'=>urlencode(I('server.REQUEST_URI')))), 1, 'redirect after 1 second');
					exit;
				}
			}else if ($acl[MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME] === 1){
				return;
			}
			
			if (($acl[MODULE_NAME.'/'.CONTROLLER_NAME.'/*'] === 0)
				||( !isset($acl[MODULE_NAME.'/'.CONTROLLER_NAME.'/*']) 
				&& !isset($acl[MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME]))){
				// access = array( m/c/* => 1, m/c/a => 0) :
				if (!is_login()){ 
					redirect(U('User/Login/login', array('redirect_to'=>urlencode(I('server.REQUEST_URI')))), 1, 'redirect after 1 second');
					exit;
				}
			}else{
				return;
			}
			
		}
	}
	
}