<?php
namespace Admin\Widget;
use Think\Controller;

abstract class AdminBaseWidget extends Controller {
	
	abstract function getMenu();
	
	public function leftmenu() {
		$menu = $this->getMenu();
		$this->assign('menu', $menu);
		$this->display('AdminBase:leftmenu');
	}
}