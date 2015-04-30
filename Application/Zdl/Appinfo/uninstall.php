<?php
if (!defined('THINK_PATH')) exit();

$db_prefix = C('DB_PREFIX');

$sql = array(
		"DROP TABLE IF EXISTS `{$db_prefix}type`;",
		"DROP TABLE IF EXISTS `{$db_prefix}status`;",
		"DROP TABLE IF EXISTS `{$db_prefix}dev`;",
		"DROP TABLE IF EXISTS `{$db_prefix}process`;",
		"DROP TABLE IF EXISTS `{$db_prefix}task`;",
		"DROP TABLE IF EXISTS `{$db_prefix}project`;"
);

foreach ($sql as $v) {
	M('')->execute($v);
}