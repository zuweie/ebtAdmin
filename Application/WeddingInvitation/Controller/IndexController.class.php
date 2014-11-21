<?php
namespace WeddingInvitation\Controller;
use Common\Controller\MyController;
use Think\Image;

class IndexController extends MyController {
	
	public function index () {
		/*
		$name = I('get.name',null);
		$title = I('get.title',null);
		
		if (isset($name)){
			$name = urldecode($name);
			$title = urldecode($title);
			$this->_getInvitationCover($name,$title);
		}
		*/
		
		// assign the cover 
		//$this->assign('cover', DATAS_DIR.'org_inv_cover.jpg');
		
		$config = D('Admin/SystemData')->get('weddinginvitation:config');
		// TODO : get Data 
		// 1 music
		// 2 pic1 pic2 pic3 pic4 pic5
		$ms = explode('|', $config['music']);
		$mids = array_filter($ms);
		$mid = current($mids);
		
		if (!empty($mid)){
			$music = D('Attach/Attach')->getAttachByIds($mid);
			$music_url = UPLOADS_DIR.$music[0]['savepath'].$music[0]['savename'];
			$this->assign('music', $music_url);
		}

		$pic = array();
		if (!empty($config['pic1'])){
			$pic[$config['pic1']] = $config['pic1'];
		}
		if (!empty($config['pic2'])){
			$pic[$config['pic2']] = $config['pic2'];
		}
		if (!empty($config['pic3'])){
			$pic[$config['pic3']] = $config['pic3'];
		}
		if (!empty($config['pic4'])){
			$pic[$config['pic4']] = $config['pic4'];
		}
		if (!empty($config['pic5'])){
			$pic[$config['pic5']] = $config['pic5'];
		}
		if (!empty($config['pic6'])){
			$pic[$config['pic6']] = $config['pic6'];
		}
		
		$_pics = D('Attach/Attach')->getAttachByIds($pic);
		
		foreach($_pics as $k => $v){
			$pic[$v['attach_id']] = UPLOADS_DIR.$v['savepath'].$v['savename']; 
		}
		
		$this->assign('pics', $pic);
		
		$this->display();
	}
	/*
	private function _getCoverNameByGuestName($name) {
		
		$sz = strlen($name);
		
		for($i=0; $i<$sz; ++$i){
			$covername .= '_'.ord($name[$i]);
		}
		//$coverfile = UPLOADS.'doc/'.$covername.'.png';
		return $covername;
	}
	*/
	/*
	private function _getInvitationCover($name, $title){
		// decode the name first.
		$covername = $this->_getCoverNameByGuestName($name);
		$coverfile = DATAS_PATH.$covername.'.png';
		
		if (file_exists($coverfile)){
			$cover_url = DATAS_DIR.$covername.'.png';
			$this->assign('cover', $cover_url);
		}else{
			//create the png cover with name
			$org_cover = DATAS_PATH.'org_inv_cover.png';
			
			$fontfile = DATAS_PATH.'simhei.ttf';
			$im = new Image();
			$im->open($org_cover);
			$im->text($name, $fontfile, 50, '#00000000', Image::IMAGE_WATER_CENTER);
			$im->text(' '.$title.'亲启      ', $fontfile, 20, '#00000000', Image::IMAGE_WATER_EAST);
			$im->save($coverfile, 'png');
			$cover_url = DATAS_DIR.$covername.'.png';
			$this->assign('cover', $cover_url);
			
		}
	}	
	*/
}