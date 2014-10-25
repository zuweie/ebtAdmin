<?php
if (!defined('THINK_PATH')) exit();

header('Content-Type: text/html; charset=utf-8');

$sql_file  =  APP_PATH.'/Demo/Appinfo/install.sql';

$res = exec_sql_file($sql_file);

if (!empty($res)){
	echo $res['error_code'];
	echo '<br />';
	echo $res['error_sql'];
	include_once(APP_PATH.'/Demo/Appinfo/uninstall.php');
	exit;
}