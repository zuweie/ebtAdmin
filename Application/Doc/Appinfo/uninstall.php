<?php
if (!defined('THINK_PATH')) exit();

$db_prefix = C('DB_PREFIX');

$sql = array(
	"DROP TABLE IF EXISTS `{$db_prefix}doc`;"
);

foreach ($sql as $v) {
	M('')->execute($v);
}
