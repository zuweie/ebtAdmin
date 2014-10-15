######应用目录
在ebtAdmin中，应用可以被安装和卸载，安装和卸载的过程是：
1 在数据库中建立这个应用的需要的数据表.
2 在Admin中注册这个应用资料，如作者，版本.
3 应用也可有被卸载，当卸载的时候，Admin模块会删除安装时建立的数据表.

若应用需要安装，需要在应用的根目录下建立一个Appinfo的文件夹。文件夹中应该新建四个文件，分别为info.php, install.php, install.sql, uninstall.php。四个文件的内容为:
1 info.php，应用的信息，如名称，作者，版本，后台入口，描述。
实例：
/****************** info.php ****************************************/
<?php
return array(
		'name' => 'xxx',
		'author' => 'xxx',
		'version' => '0.1',
		'admin_entrance'=>'User/Admin/index',
		'desc' => '用户模块'
);
/********************************************************************/

2 install.php，安装该应用时，调用的脚本，一般会调用install.sql来生城数据表。
实例：
/******************** install.php ******************************************/
<?php
if (!defined('THINK_PATH')) exit();

header('Content-Type: text/html; charset=utf-8');

$sql_file  =  APP_PATH.'/xxx/Appinfo/install.sql';

$res = exec_sql_file($sql_file);

if (!empty($res)){
	echo $res['error_code'];
	echo '<br />';
	echo $res['error_sql'];
	include_once(APP_PATH.'/xxx/uninstall.php');
	exit;
}
/****************************************************************************/

3 install.sql,安装时调用的sql脚本，一般用于生成该应用所需要的数据表
实例：
/******************* install.sql ******************************************/
/*
* tables for user
*
* author : zuweie
* verson : 0.1
*/

-- -------------------------------------
-- Table structure for `user`
-- -------------------------------------

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
	`uid` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'Uid',
	`nickname` VARCHAR(255) DEFAULT NULL COMMENT 'nick name',
	`login` VARCHAR(255) DEFAULT NULL COMMENT 'account',
	`password` VARCHAR(255) DEFAULT NULL COMMENT 'password',
	`user_group` INT(11) DEFAULT 0 COMMENT 'user group id',
	`user_data`  INT(11) DEFAULT 0 COMMENT 'user detail information',
	`status`  TINYINT(1) DEFAULT 0 COMMENT 'user status',
	`ctime` INT(11) NOT NULL COMMENT 'create time'
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_privilege`;
CREATE TABLE `user_privilege` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'id',
	`uid` INT(11) UNSIGNED NOT NULL COMMENT 'user id', 
	`privilege` INT(11) UNSIGNED NOT NULL COMMENT 'privilege'
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group` (
	`gid` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'gid',
	`title` VARCHAR(255) DEFAULT NULL COMMENT 'title',
	`uid` INT(11) DEFAULT 0 COMMENT 'owner id',
	`status` TINYINT(1) DEFAULT 0 COMMENT 'status',
	`ctime` INT(11) COMMENT 'create time'
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `group_privilege`;
CREATE TABLE `group_privilege` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'id',
	`gid` INT(11) UNSIGNED NOT NULL COMMENT 'group id',
	`privilege` INT(11) UNSIGNED NOT NULL COMMENT 'privilege' comment 'privielge'
)ENGINE=MyISAM DEFAULT CHARSET=utf8;;

DROP TABLE IF EXISTS `privilege`;
CREATE TABLE `privilege` (
	`pid` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'pid',
	`title` VARCHAR (255) DEFAULT NULL COMMENT 'title',
	`privilege` TEXT DEFAULT NULL COMMENT 'privilege text'
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT  INTO `privilege` VALUES ('1', 'ADMIN', 'admin:3');
/**************************************************************************/

4 uninstall.php 卸载该应用时所需要的的脚本，一般为删除安装时建立的数据表。
实例：
/************************** uninstall.php *********************************/
<?php
if (!defined('THINK_PATH')) exit();

$db_prefix = C('DB_PREFIX');

$sql = array(
		"DROP TABLE IF EXISTS `{$db_prefix}user`;"

		/** drop the other table 
		, ......
		, .....
		*/
);

foreach ($sql as $v) {
	M('')->execute($v);
}
/**************************************************************************/

