/*
* tables for zdl
*
* author : zuweie
* verson : 0.1
*/

DROP TABLE IF EXISTS `__PREFIX__type`;
CREATE TABLE `__PREFIX__type` (
	`ty_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'ID',
	`ty_name` VARCHAR(255) DEFAULT NULL COMMENT '类型名称',
	`ty_code` INT(11) DEFAULT 0 COMMENT '键值',
	`createdAt` INT(11) DEFAULT 0,
	`updatedAt` INT(11) DEFAULT 0
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `__PREFIX__status`;
CREATE TABLE `__PREFIX__status` (
	`s_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'ID',
	`s_name` VARCHAR(255) DEFAULT NULL COMMENT '类型名称',
	`s_code` INT(11) DEFAULT 0 COMMENT '键值',
	`createdAt` INT(11) DEFAULT 0,
	`updatedAt` INT(11) DEFAULT 0
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `__PREFIX__dev`;
CREATE TABLE `__PREFIX__dev` (
	`dev_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'id',
	`dev_name` VARCHAR(255) DEFAULT NULL COMMENT '设备名称',
	`dev_zbh` VARCHAR(255) DEFAULT NULL COMMENT '自编号',
	`dev_bah` VARCHAR(255) DEFAULT NULL COMMENT '备案号',
	`dev_cch` VARCHAR(255) DEFAULT NULL COMMENT '出厂号',
	`dev_attr` TEXT DEFAULT NULL COMMENT '设备参数',
	`dev_type` INT(11) DEFAULT 0 COMMENT '类型',
	`dev_process` INT(11) DEFAULT -1 COMMENT '使用状态',
	`dev_mainbody` TINYINT DEFAULT 0 COMMENT '是否主体设备', 
	`createdAt` INT(11) DEFAULT 0,
	`updatedAt` INT(11) DEFAULT 0
)ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `__PREFIX__process`;
CREATE TABLE `__PREFIX__process` (
	`p_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'id',
	`p_title` VARCHAR(1024) DEFAULT NULL COMMENT '过程名称',
	`p_context` TEXT DEFAULT NULL COMMENT '设备的使用状态',
	`p_project` INT(11) DEFAULT 0 COMMENT '设备参与的工程',
	`p_maindev` INT(11) DEFAULT -1 COMMENT '主设备',
	`p_status` INT(11) DEFAULT 0 COMMENT '状态吗，0为idle',
	`p_opened` INT(11) DEFAULT 0 COMMENT '设备开始使用时间',
	`p_closed` INT(11) DEFAULT 0 COMMENT '设备结束使用时间',
	`createdAt` INT(11) DEFAULT 0,
	`updatedAt` INT(11) DEFAULT 0
)ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `__PREFIX__task`;
CREATE TABLE `__PREFIX__task` (
	`t_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'id',
	`t_title` VARCHAR(255) DEFAULT NULL COMMENT '标题',
	`t_creater` INT(11) DEFAULT 0 COMMENT '活动发起人', 
	`t_userid` INT(11) DEFAULT 0 COMMENT '活动经手人',
	`t_usergroup` INT(11) DEFAULT 0 COMMENT '经手团队',
	`t_type` INT(11) DEFAULT 0 COMMENT '活动类型',
	`t_request` TEXT DEFAULT NULL COMMENT '活动请求/描述',
	`t_response` TEXT DEFAULT NULL COMMENT '处理结果',
	`t_attention` TEXT DEFAULT NULL COMMENT '注意事项',
	`t_attach` VARCHAR(255) DEFAULT NULL COMMENT '处理结果的照片/或附件',
	`t_process` INT(11) DEFAULT 0 COMMENT '处理的进程号',
	`t_dev`     INT(11) DEFAULT 0 COMMENT '处理的设备',
	`t_date`    INT(11) DEFAULT 0 COMMENT '处理日期',
	`t_opened`    INT(11) DEFAULT 0 COMMENT '开始日期',
	`t_closed`   INT(11) DEFAULT 0 COMMENT '结束日期',
	`t_expect_closed`  INT(11) DEFAULT 0 COMMENT '期望结束日期',
	`t_act_sql` TEXT DEFAULT NULL COMMENT '活动影响结果',
	`t_status` INT(11) DEFAULT 0 COMMENT '活动状态',
	`createdAt` INT(11) DEFAULT 0,
	`updatedAt` INT(11) DEFAULT 0
)ENGINE=MyISAM DEFAULT CHARSET=UTF8;

DROP TABLE IF EXISTS `__PREFIX__project`;
CREATE TABLE `__PREFIX__project` (
	`pro_id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT 'id',
	`pro_title` VARCHAR(1024) DEFAULT NULL COMMENT '工程名称',
	`pro_addr` VARCHAR(1024) DEFAULT NULL COMMENT '工程地址',
	`pro_status` INT(11) DEFAULT 0 COMMENT '工程状态',
	`pro_opened` INT(11) DEFAULT 0 COMMENT '工程开始',
	`pro_closed` INT(11) DEFAULT 0 COMMENT '工程结束',
	`createdAt` INT(11) DEFAULT 0,
	`updatedAt` INT(11) DEFAULT 0
)ENGINE=MyISAM DEFAULT CHARSET=utf8;







