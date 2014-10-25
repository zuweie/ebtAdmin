<?php
namespace Common\Behavior;

MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;

class CheckPrivilegeBehavior {
	
	public function run (&$param){
		$pri_ctrl = C('privilege_ctrl');
		if ($pri_ctrl){
			$privilege = C('privilege');
			if(isset($privilege[MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME])){
				$reagent = $privilege[MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME];
				if(!verify_static_privilege(get_login_privilege(), $reagent) 
				&& !verify_static_privilege(get_login_group_privilege(), $reagent)){
					die (L('ERR_NO_PRIVILEGE'));
				}
			}else if (isset($privilege[MODULE_NAME.'/'.CONTROLLER_NAME.'/*'])){
				$reagent = $privilege[MODULE_NAME.'/'.CONTROLLER_NAME.'/*'];
				if(!verify_static_privilege(get_login_privilege(), $reagent)
				&& !verify_static_privilege(get_login_group_privilege(), $reagent)){
					die (L('ERR_NO_PRIVILEGE'));
				}
			}
			
			/*
			unset($reagent);
			$group_privilege = C('group_privilege');
			if (isset($group_privilege[MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME])){
				$reagent = $group_privilege[MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME];
				if(!verify_static_privilege(get_login_group_privilege(), $reagent)){
					//redirect(U('User/Login/login', array('redirect_to'=>urlencode(I('server.REQUEST_URI')))), L('ERR_NO_PRIVILEGE'));
					echo (L('ERR_NO_PRIVILEGE'));
					exit;
				}
			}else if (isset($group_privilege[MODULE_NAME.'/'.CONTROLLER_NAME.'/*'])){
				$reagent = $group_privilege[MODULE_NAME.'/'.CONTROLLER_NAME.'/*'];
				if(!verify_static_privilege(get_login_group_privilege(), $reagent)){
					//redirect(U('User/Login/login', array('redirect_to'=>urlencode(I('server.REQUEST_URI')))), L('ERR_NO_PRIVILEGE'));
					echo (L('ERR_NO_PRIVILEGE'));
					exit;
				}
			}
			*/
			
		}
		return;
	}
	
}