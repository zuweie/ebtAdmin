<?php
namespace Common\Controller;
use Think\Controller;

class MyController extends Controller {
	
	public function ajaxReturnJson ($status, $data=''){
		$ret['status'] = $status;
		$ret['data'] = $data;
		echo json_encode($ret);
		exit;
	}
	
	protected $mid = -1;
}