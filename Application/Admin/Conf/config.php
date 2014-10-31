<?php
return array(
	/* 1 means you can access it do not need login */
	'access_ctrl' => true,
	
	'access' => array(
			'Admin/Install/install' => 1,
			'Admin/Install/doInstall' => 1
	),
	
	'privilege_ctrl' => true,
		
	'privilege' => array(
		'Admin/Public/*' 		 	=> array('admin'=>0x3),
		'Admin/Admin/installApp' 	=> array('app'=>0x2),
		'Admin/Admin/unInstallApp' 	=> array('app'=>0x2),
		'Admin/Admin/installSystemApp' 	 => array('sysapp'=>0x2),
		'Admin/Admin/unInstallSystemApp' => array('sysapp'=>0x2),
		'Admin/Admin/doEditAppInfo' 	 => array('sysapp'=>0x2)
	)
);