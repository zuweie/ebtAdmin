<?php
namespace Widget\Widget\DateSelectWidget;
use Widget\Widget\BaseWidget;

class DateSelectWidget extends BaseWidget {
	public function render($data){
		$this->assign('data', $data);
		return $this->display(dirname(__FILE__).'/dateSelect.html');
	}
}

