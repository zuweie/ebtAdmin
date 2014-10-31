<?php
/**
 * 公共模块函数库，省级行政级别
 * author : zuweie
 * version: v0.1
 * date   : 2014-9-20。 
 */

/**
 * 执行SQL文件
 * @param string  $file 要执行的sql文件路径
 * @param boolean $stop 遇错是否停止  默认为true
 * @param string  $db_charset 数据库编码 默认为utf-8
 * @return array
 */
function exec_sql_file($file,  $stop = true,$db_charset = 'utf-8'){

	if (!is_readable($file)) {
		$error = array(
				'error_code' => 'SQL文件不可读',
				'error_sql'  => '',
		);
		return $error;
	}
	
	$fp = fopen($file, 'rb');
	$sql = fread($fp, filesize($file));
	fclose($fp);
	
	$prefix = C('DB_PREFIX');
	//$sql = str_replace("\r", "\n", str_replace('`'.'ts_', '`'.M('')->tablePrefix, $sql));
	$sql = str_replace("\r", "\n", str_replace('`'.'__PREFIX__', '`'.$prefix, $sql));
	foreach (explode(";\n", trim($sql)) as $query) {
		$query = trim($query);
		if($query) {
			if(substr($query, 0, 12) == 'CREATE TABLE') {
				//预处理建表语句
				$db_charset = (strpos($db_charset, '-') === FALSE) ? $db_charset : str_replace('-', '', $db_charset);
				$type   = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $query));
				$type   = in_array($type, array("MYISAM", "HEAP")) ? $type : "MYISAM";
				$_temp_query = preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $query).
				(mysql_get_server_info() > "4.1" ? " ENGINE=$type DEFAULT CHARSET=$db_charset" : " TYPE=$type");
	
				$res = M('')->execute($_temp_query);
			}else {
				$res = M('')->execute($query);
			}
			if($res === false) {
				$error[] = array(
						'error_code' => M('')->getDbError(),
						'error_sql'  => $query,
				);
	
				if($stop) return $error[0];
			}
		}
	}
	return $error;
}

/**
 * 登录/退出 函数群 
 * author:zuweie
 * @param:null
 */
function is_login(){
	$val = session('login');
	return isset($val);
}

/**
 * 获取登录用户权限
 * 
 */

function get_login_privilege(){
	$usr = session('login');
	if (isset($usr)){
		return $usr['privilege'];
	}
	return $usr;
}

function get_login_group_privilege() {
	$user = session('login');
	if (isset($user)){
		return $user['group_privilege'];
	}
	return $user;
}

/**
 * 静态权限验证函数
 * @param array sample 测试样本权限列表
 * @param array reagent 试剂权限列表
 * @param int mask_bit_size 试剂权限测试位数，默认为两位，即读写。
 * @return  若完全符合 试剂 权限列表权限列表要求,返回True,否则返回false.
 */

function verify_static_privilege($sample, $reagent, $mask_bit_size = 2){
	
	foreach($reagent as $k => $v){
		
		//目标权限值
		$sample_value = intval($sample[$k]);
		//样本权限值
		$reagent_value = intval($v);

		if(isset($sample_value)){
			
			for($i=0; $i<$mask_bit_size; ++$i){	
				$mask = 0x1;
				$mask = $mask << $i;
				$reagent_bit_value = $reagent_value & $mask;
				if ($reagent_bit_value !== 0){
					if (($reagent_bit_value & $sample_value) === 0){
						return false;
					}
				}
			}
		}else {
			return false;
		}
	}
	
	return true;
}

/**
 * 登录函数
 * @param string $login 登录帐号
 * @param string $pass  登录密码
 * @return true / false 
 */
function login($login, $pass){
	
	session('login', null);
	$res = D('User/User')->getLoginUser($login, $pass);
	if (!$res){
		return $res;
	}else{
		session('login', $res);
		return true;
	}
}

/**
 * 获取登录用户信息
 * @return Login User 信息
 */
function get_login_user (){
	$user = session('login');
	return $user;
}

function get_login_user_id(){
	$user = session('login');
	if (isset($user)){
		return $user['uid'];
	}else{
		return -1;
	}
}
/**
 * 登出
 * @return mixed
 */
function logout() {
	return session('login', null);
}

/**
 * 获取用户浏览器型号。新加浏览器，修改代码，增加特征字符串.把IE加到12.0 可以使用5-10年了.
 */
function getBrowser(){
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'Maxthon')) {
		$browser = 'Maxthon';
	} elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 12.0')) {
		$browser = 'IE12.0';
	} elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 11.0')) {
		$browser = 'IE11.0';
	} elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 10.0')) {
		$browser = 'IE10.0';
	} elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9.0')) {
		$browser = 'IE9.0';
	} elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0')) {
		$browser = 'IE8.0';
	} elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0')) {
		$browser = 'IE7.0';
	} elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0')) {
		$browser = 'IE6.0';
	} elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'NetCaptor')) {
		$browser = 'NetCaptor';
	} elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape')) {
		$browser = 'Netscape';
	} elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Lynx')) {
		$browser = 'Lynx';
	} elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera')) {
		$browser = 'Opera';
	} elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
		$browser = 'Google';
	} elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
		$browser = 'Firefox';
	} elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari')) {
		$browser = 'Safari';
	} elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'iphone') || strpos($_SERVER['HTTP_USER_AGENT'], 'ipod')) {
		$browser = 'iphone';
	} elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'ipad')) {
		$browser = 'iphone';
	} elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'android')) {
		$browser = 'android';
	} else {
		$browser = 'other';
	}
	return $browser;
}

/**
 * t函数用于过滤标签，输出没有html的干净的文本
 * @param string text 文本内容
 * @return string 处理后内容
 */
function tt($text){
    $text = nl2br($text);
    $text = real_strip_tags($text);
    $text = addslashes($text);
    $text = trim($text);
    return $text;
}


function real_strip_tags($str, $allowable_tags="") {
	$str = html_entity_decode($str,ENT_QUOTES,'UTF-8');
	return strip_tags($str, $allowable_tags);
}

/**
 * 添加参数到url后面
 * @param string url 原生的url
 * @param array | string params 添加的参数
 * @return string 新的url
 */
function push_param_to_url ($url, $param=''){
	$p = '';
	if (is_array($param)){
		foreach($param as $k => $v){
			$p = '&'.$p.$k.'='.$v;
		}
	}else if (is_string($param)){
		$p = '&'.$param;
	}
	
	if (strpos($url, '?') === false){
		$url = $url .'?'. trim($p, '&');
	}else {
		$url = $url.$p;
	}
	
	return $url;
}

/**
 * 调用Widget
 * @param string name 页面组件的名字
 * @param string act  页面组件接口
 * @param array  data 页面组件的参数
 * @return void
 */
function widget($name, $data=array(), $act='render'){
	
	$params[] = $data;
	return W('Widget/'.$name.'Widget/'.$name.'/'.$act, $params);
}


/**
 * 友好的时间显示
 *
 * @param int    $sTime 待显示的时间
 * @param string $type  类型. normal | mohu | full | ymd | other
 * @param string $alt   已失效
 * @return string
 */
function friendly_date($sTime, $type = 'normal', $alt = 'false') {
	if (!$sTime)
		return '';
	//sTime=源时间，cTime=当前时间，dTime=时间差
	$cTime      =   time();
	$dTime      =   $cTime - $sTime;
	$dDay       =   intval(date("z",$cTime)) - intval(date("z",$sTime));
	//$dDay     =   intval($dTime/3600/24);
	$dYear      =   intval(date("Y",$cTime)) - intval(date("Y",$sTime));
	//normal：n秒前，n分钟前，n小时前，日期
	if($type=='normal'){
		if( $dTime < 60 ){
			if($dTime < 10){
				return '刚刚';    //by yangjs
			}else{
				return intval(floor($dTime / 10) * 10)."秒前";
			}
		}elseif( $dTime < 3600 ){
			return intval($dTime/60)."分钟前";
			//今天的数据.年份相同.日期相同.
		}elseif( $dYear==0 && $dDay == 0  ){
			//return intval($dTime/3600)."小时前";
			return '今天'.date('H:i',$sTime);
		}elseif($dYear==0){
			return date("m-d H:i",$sTime);
		}else{
			return date("Y-m-d H:i",$sTime);
		}
	}elseif($type=='mohu'){
		if( $dTime < 60 ){
			return $dTime."秒前";
		}elseif( $dTime < 3600 ){
			return intval($dTime/60)."分钟前";
		}elseif( $dTime >= 3600 && $dDay == 0  ){
			return intval($dTime/3600)."小时前";
		}elseif( $dDay > 0 && $dDay<=7 ){
			return intval($dDay)."天前";
		}elseif( $dDay > 7 &&  $dDay <= 30 ){
			return intval($dDay/7) . '周前';
		}elseif( $dDay > 30 ){
			return intval($dDay/30) . '个月前';
		}
		//full: Y-m-d , H:i:s
	}elseif($type=='full'){
		return date("Y-m-d , H:i:s",$sTime);
	}elseif($type=='ymd'){
		return date("Y-m-d",$sTime);
	}else{
		if( $dTime < 60 ){
			return $dTime."秒前";
		}elseif( $dTime < 3600 ){
			return intval($dTime/60)."分钟前";
		}elseif( $dTime >= 3600 && $dDay == 0  ){
			return intval($dTime/3600)."小时前";
		}elseif($dYear==0){
			return date("Y-m-d H:i:s",$sTime);
		}else{
			return date("Y-m-d H:i:s",$sTime);
		}
	}
}

/**
 * 字节格式化 把字节数格式为 B K M G T 描述的大小
 * @return string
 */
function byte_format ($size, $dec=2){
	$a = array("B", "KB", "MB", "GB", "TB", "PB");
	$pos = 0;
	while ($size >= 1024) {
		$size /= 1024;
		$pos++;
	}
	return round($size,$dec)." ".$a[$pos];	
}

// 自动转换字符集 支持数组转换
function auto_charset($fContents,$from,$to){
	$from   =  strtoupper($from)=='UTF8'? 'utf-8':$from;
	$to       =  strtoupper($to)=='UTF8'? 'utf-8':$to;
	if( strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents)) ){
		//如果编码相同或者非字符串标量则不转换
		return $fContents;
	}
	if(is_string($fContents) ) {
		if(function_exists('iconv')){
			return iconv($from,$to,$fContents);
		}else{
			return $fContents;
		}
	}
	elseif(is_array($fContents)){
		foreach ( $fContents as $key => $val ) {
			$_key =     auto_charset($key,$from,$to);
			$fContents[$_key] = auto_charset($val,$from,$to);
			if($key != $_key )
				unset($fContents[$key]);
		}
		return $fContents;
	}
	else{
		return $fContents;
	}
}