<?php
namespace Admin\Model;
use Common\Model\MyModel;

class SystemConfigModel extends MyModel {
	
	protected $tableName = 'system_config';
	
	protected $fields = array(0=>'id', 1=>'list', 2=>'key', 3=>'value', 4=>'utime', '_autoinc'=>true, '_pk'=>'id');
	
	protected $pk = 'id';
	// 默认列表名
	protected $list_name = 'global';
	
	//键值白名单，主要用于获取和设置配置文件某个
	protected $whiteList = array('site'=>'');
	
	/**
	 * 写入参数列表
	 * @param string $listName 参数列表list
	 * @param array $listData 存入的数据，形式为key=>value
	 * @return boolean 是否写入成功
	*/
	public function pageKey_lput($listName = '', $listData = array()) {
		// 初始化list_name
		$listName = $this->_strip_key($listName);
		$result = false;
		// 格式化数据
		if(is_array($listData)) {
			$insert_sql	.=	"REPLACE INTO __TABLE__ (`list`,`key`,`value`,`utime`) VALUES ";
			foreach($listData as $key => $data) {
				$insert_sql	.= " ('$listName','$key','".serialize($data)."','".time()."') ,";
			}
			$insert_sql	= rtrim($insert_sql,',');
			// 插入数据列表
			$result	= $this->execute($insert_sql);
		}
	
		$cache_id = '_system_config_lget_'.$listName;
	
		$delCache = F($cache_id, null);	//删除缓存，不要使用主动创建发方式、因为listData不一定是listName的全部值
	
		return $result;
	}
	
	/**
	 * 读取数据list:key
	 * @param string $key 要获取的某个参数list:key；如果没有:则认为，只有list没有key
	 * @return string 相应的list中的key值数据
	 */
	public function pagekey_get($key) {
		$key = $this->_strip_key($key);
	
		$keys = explode(':', $key);
		static $_res = array();
		if(isset($_res[$key])) {
			return $_res[$key];
		}
		$list = $this->pagekey_lget($keys[0]);
		return $list ? $list[$keys[1]] : '';
	}
	
	/**
	 * 读取参数列表
	 * @param string $list_name 参数列表list
	 * @param boolean $nostatic 是否不使用静态缓存，默认为false
	 * @return array 参数列表
	 */
	public function pagekey_lget($list_name = '', $nostatic = false) {
	
		$list_name = $this->_strip_key($list_name);
	
		static $_res = array();
		if(isset($_res[$list_name]) && !$nostatic) {
			return $_res[$list_name];
		}
	
		$cache_id = '_system_config_lget_'.$list_name;
		
		if(($data = F($cache_id)) === false || $data == '' || empty($data)) {
			$data = array();
			
			// old code
			//$map['`list`'] = $list_name;
			$map['list'] = $list_name;
			
			// old code 
			//$result	= D('system_config')->order('id ASC')->where($map)->findAll();
			
			$result	= D('system_config')->order('id ASC')->where($map)->select();
			
			if($result) {
				foreach($result as $v) {
					$data[$v['key']] = unserialize($v['value']);
				}
			}
			F($cache_id, $data);
		}
		//dump($data);exit;
		$_res[$list_name] = $data;
		return $_res[$list_name];
	}
	
	/**
	 * 过滤key值
	 * @param string $key 只允许格式，数字字母下划线，list:key不允许出现html代码和这些符号 ' " & * % ^ $ ? ->
	 * @return string 过滤后的key值
	 */
	protected function _strip_key($key = '') {
		if($key == '') {
			return $this->list_name;
		} else {
			return preg_replace('/([^0-9a-zA-Z\_\:])/', '', $key);
		}
	}
	
}