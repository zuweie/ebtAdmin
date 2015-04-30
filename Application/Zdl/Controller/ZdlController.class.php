<?php
namespace Zdl\Controller;
use Common\Controller\MyController;

class ZdlController extends MyController {
	public function index(){
		$projects = D('Zdl/Project')->select();
		$this->assign('projects', $projects);
		$this->display();
	}
	
	public function machinelist() {
		$this->display();
	}
	
	public function machine() {
		$this->diaplay();
	}
}