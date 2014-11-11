/*
* tables for WeddingInvitation
*
* author : zuweie
* verson : 0.1
*/

DROP TABLE IF EXISTS `__PREFIX__guest`;
CREATE TABLE `__PREFIX__guest` (
	`guest_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'DOC id',
	`name` VARCHAR(255) DEFAULT NULL COMMENT 'name',
	`title` VARCHAR(255) DEFAULT NULL COMMENT 'title',
	`people` INT(255) DEFAULT 0 COMMENT 'The number he carry',
	`uid`  INT(11) DEFAULT 0 COMMENT 'Whose guest',
	`desc` TEXT DEFAULT NULL COMMENT 'describe',
	`status` TINYINT DEFAULT 0 COMMENT 'guest status',
	`ctime` INT(11) DEFAULT 0 COMMENT 'create time'
)ENGINE=MyISAM DEFAULT CHARSET=utf8;
