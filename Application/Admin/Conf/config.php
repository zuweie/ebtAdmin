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
		'Admin/Public/*' => array('admin'=>0x3),
	),
		
	'plugins' => array(
		array('title'=>'应用','name'=>'AppManager'),
	)
);