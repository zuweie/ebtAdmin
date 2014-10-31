/*
* tables for Attach
*
* author : zuweie
* verson : 0.1
*/

DROP TABLE IF EXISTS `__PREFIX__attach`;
CREATE TABLE `__PREFIX__attach` (
	`attach_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'attach id',
	`ext` VARCHAR(15) DEFAULT NULL COMMENT 'extension',
	`size` INT(11) DEFAULT 0 COMMENT 'size of the attach (KB)',
	`name`  VARCHAR(255) DEFAULT NULL COMMENT 'Original file name',
	`savename` VARCHAR(255) DEFAULT NULL COMMENT 'the file name it uploaded',
	`savepath` VARCHAR(255) DEFAULT NULL COMMENT 'save path',
	`filepath` VARCHAR(255) DEFAULT NULL COMMENT 'file path',
	`type` VARCHAR(255) DEFAULT NULL COMMENT 'upload file mime type',
	`md5` VARCHAR(255) DEFAULT NULL COMMENT 'md5 code',
	`sha1` VARCHAR(255) DEFAULT NULL COMMENT 'sha1 code',
	`ctime` INT(11) DEFAULT 0 COMMENT 'create time'
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

