/*
* tables for Admin apps
*
* author : zuweie
* verson : 0.1
*/

-- -------------------------------------
-- Table structure for `app`
-- -------------------------------------
DROP TABLE IF EXISTS `__PREFIX__app`;
CREATE TABLE `__PREFIX__app` (
	`app_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'app id',
	`app_name` VARCHAR(255) DEFAULT NULL COMMENT 'app name',
	`app_title` VARCHAR(255) DEFAULT NULL COMMENT 'app title',
	`app_author` VARCHAR(255) DEFAULT NULL COMMENT 'author',
	`app_admin_entrance` VARCHAR(255) DEFAULT NULL COMMENT 'admin entrance',
	`app_type` VARCHAR(128) DEFAULT NULL COMMENT 'app type',
	`app_admin_layout` TINYINT (1) DEFAULT 1 COMMENT 'display on : 1 only on the AppManager submenu, 2 header , 3 both', 
	`app_version` VARCHAR(255) DEFAULT NULL COMMENT 'version',
	`app_desc` TEXT DEFAULT NULL COMMENT 'describe',
	`ctime` INT(11) NOT NULL COMMENT 'create time'
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `__PREFIX__system_config`;
CREATE TABLE `__PREFIX__system_config` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'id',
	`list` CHAR(30) DEFAULT 'default' COMMENT 'name of list',
	`key` CHAR(50) DEFAULT 'default' COMMENT 'key',
	`value` TEXT DEFAULT NULL COMMENT 'value',
	`utime` INT(11) DEFAULT 0 COMMENT 'updated time',
	UNIQUE KEY `list_key` (`list`,`key`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `__PREFIX__system_data`;
CREATE TABLE `__PREFIX__system_data` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'id',
	`list` CHAR(30) DEFAULT 'default' COMMENT 'name of list',
	`key` CHAR (50) DEFAULT 'default' COMMENT 'key',
	`value` TEXT DEFAULT NULL COMMENT 'value',
	`utime` INT(11) DEFAULT 0 COMMENT 'updated time',
	UNIQUE KEY `list_key` (`list`,`key`),
	KEY `list_id` (`list`,`id`)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;



