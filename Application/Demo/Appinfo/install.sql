/*
* tables for Demo
*
* author : zuweie
* verson : 0.1
*/

DROP TABLE IF EXISTS `demo`;
CREATE TABLE `demo` (
	`demo_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'id',
	`title` VARCHAR(255) DEFAULT NULL COMMENT 'title' COMMENT 'title',
	`text`  TEXT DEFAULT NULL COMMENT 'text'
)ENGINE=MyISAM DEFAULT CHARSET=utf8; 
