<?php
namespace Widget\Widget\FlexPaperWidget;
use Widget\Widget\BaseWidget;

class FlexPaperWidget extends BaseWidget {
	
	public function render($data){
		$this->assign('width', $data['width']);
		$this->assign('height', $data['height']);
		$this->assign('pdf', $data['pdf']);
		
		
		$width = !empty($data['width']) ? intval($data['width']) : 790;
		
		$height = !empty($data['height']) ? intval($data['height']) : 520;
		
		$url = '/Application/Doc/FlexPaper/php/simple_document_1.php?width='.$width.'&height='.$height;
		
		if (!empty($data['pdf'])){
			$url .= '&doc='.$data['pdf'];
		}
		
		$this->assign('width', $width);
		$this->assign('height', $height);
		$this->assign('url', $url);
		
		return $this->display(dirname(__FILE__).'/flexpaper.html');
	}
	
}