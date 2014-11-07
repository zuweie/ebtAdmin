/*
* tables for FlexPaper apps
*
* author : zuweie
* verson : 0.1
*/

DROP TABLE IF EXISTS `__PREFIX__doc`;
CREATE TABLE `__PREFIX__doc` (
	`doc_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'DOC id',
	`title` VARCHAR(255) DEFAULT NULL COMMENT 'title',
	`attach` VARCHAR(255) DEFAULT NULL COMMENT 'upload attach',
	`desc` TEXT DEFAULT NULL COMMENT 'describe',
	`ctime` INT(11) DEFAULT 0 COMMENT 'create time'
)ENGINE=MyISAM DEFAULT CHARSET=utf8;
