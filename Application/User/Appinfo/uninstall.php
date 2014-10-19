<?php
if (!defined('THINK_PATH')) exit();

$db_prefix = C('DB_PREFIX');

$sql = array(
		"DROP TABLE IF EXISTS `{$db_prefix}user`;",
		"DROP TABLE IF EXISTS `{$db_prefix}user_privilege`;",
		"DROP TABLE IF EXISTS `{$db_prefix}user_group`;",
		"DROP TABLE IF EXISTS `{$db_prefix}group_privilege`;",
		"DROP TABLE IF EXISTS `{$db_prefix}privilege`;"
);

foreach ($sql as $v) {
	M('')->execute($v);
}
