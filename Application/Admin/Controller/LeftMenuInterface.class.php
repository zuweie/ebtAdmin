<?php
namespace Admin\Controller;
interface LeftMenuInterface {
	
	/**
	 * 当后台主框架加载此App的Admin模块时，App可以初始化其在后台框架左侧的菜单栏。
	 * 后台框架的左侧菜单栏的数据格式为
	 * ***********************************************************************
	 * leftMenu['title'] = 'xxx';
	 * leftMenu['id']    = 'xxx';
	 * leftMenu['submenu'] = array(
	 *		 			     	array('title'=>'xxx', 'id'=>'xxx', 'url'=>'xxx),
	 *		   				 	array(...),
	 *		   				 	array(...),
	 * 		   				 	array(...))
	 * 						 );
	 * ***********************************************************************
	 * @param unknown $layout
	 * @return void;
	 */
	public function leftMenu();
}