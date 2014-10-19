<?php
if (!defined('THINK_PATH')) exit();

$db_prefix = C('DB_PREFIX');

$sql = array(
	"DROP TABLE IF EXISTS `{$db_prefix}app`;",
	"DROP TABLE IF EXISTS `{$db_prefix}system_config`;",
	"DROP TABLE IF EXISTS `{$db_prefix}system_data`;"
);

foreach ($sql as $v) {
	M('')->execute($v);
}
