<?php
if (!defined('THINK_PATH')) exit();

header('Content-Type: text/html; charset=utf-8');

$sql_file  =  APP_PATH.'/Admin/Appinfo/install.sql';

$res = exec_sql_file($sql_file);

if (!empty($res)){
	echo $res['error_code'];
	echo '<br />';
	echo $res['error_sql'];
	include_once(APP_PATH.'/Admin/uninstall.php');
	exit;
}