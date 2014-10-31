<?php
namespace Widget\Controller;
use Think\Controller;

class WidgetAgentController extends Controller {
	
	public function agentWidget() {
		$w = I('request.w');
		$a = I('request.wa');
		return widget($w,'', $a);
	}
}