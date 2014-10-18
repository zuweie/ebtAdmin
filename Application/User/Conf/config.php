<?php
return array (
	'access_ctrl' => true,
	'access' => array('User/Login/login'=>1, 
					   'User/Login/doLogin'=>1, 
						'User/Login/logout'=>1),
		
	'privilege_ctrl' => true,
	
	'privilege' => array(
		'User/Admin/*'=>array('admin'=>0x3, 'privilege'=>0x3)
	)
);