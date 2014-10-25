<?php
return array (
	'access_ctrl' => true,
	'access' => array('User/Login/login'=>1, 
					   'User/Login/doLogin'=>1, 
						'User/Login/logout'=>1),
		
	'privilege_ctrl' => true,
	
	'privilege' => array(
		'User/Admin/index'		=> array('admin'=>0x3, 'usr'=>0x1),
		'User/Admin/editUser' 	=> array('admin'=>0x3, 'usr'=>0x1),
		'User/Admin/doEditUser' => array('admin'=>0x3, 'usr'=>0x2),
		'User/Admin/addUser'	=> array('admin'=>0x3, 'usr'=>0x1),
		'User/Admin/doAddUser'  => array('admin'=>0x3, 'usr'=>0x2),
		'User/Admin/delUser'    => array('admin'=>0x3, 'usr'=>0x2),
		'User/Admin/privilege'  => array('admin'=>0x3, 'privilege'=>0x1),
		'User/Admin/addPrivilege'    => array('admin'=>0x3, 'privilege'=>0x2),		
		'User/Admin/editPrivilege' 	 => array('admin'=>0x3, 'privilege'=>0x1),
		'User/Admin/doEditPrivilege' => array('admin'=>0x3, 'privilege'=>0x2),
		'User/Admin/delPrivilege'    => array('admin'=>0x3, 'privilege'=>0x2),
		'User/Admin/userPrivilege'   => array('usr'=>0x1, 'privilege'=>0x1),
		'User/Admin/addUserPrivilege' => array('usr'=>0x2, 'privilege'=>0x2),
		'User/Admin/delUserPrivilege' => array('usr'=>0x2, 'privilege'=>0x2),
		'User/Admin/groupPrivilege'   => array('group'=>0x1, 'privilege'=>0x1),
		'User/Admin/addGroupPrivilege' => array('group'=>0x2, 'privilege'=>0x2),
		'User/Admin/delGroupPrivlege' => array('group'=>0x2, 'privilege'=>0x2)
	)
);