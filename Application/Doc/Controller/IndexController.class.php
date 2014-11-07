<?php
namespace Doc\Controller;
use Common\Controller\MyController;

class IndexController extends MyController {
	
	public function index (){
		$pdf = I('get.pdf');
		$width = I('get.width');
		$height = I('get.height');
		
		$this->assign('pdf', $pdf);
		$this->assign('width', $width);
		$this->assign('height', $height);
		
		$this->display();
	}
	
}
