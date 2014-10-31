<?php
namespace Widget\Widget\UploadWidget;
use Widget\Widget\BaseWidget;
use Think\Upload;
use Org\Net\Http;

class UploadWidget extends BaseWidget {
	
	public function render($data){
		
		$this->_assignVar($data);
		
		//$this->assign('data', $data);
		if (isset($data['uploadType']) && $data['uploadType'] == 'image'){
			$this->display(dirname(__FILE__).'/uploadimage.html');
		}else{
			$this->display(dirname(__FILE__).'/uploadfile.html');
		}
	}
	
	public function save() {
		
		$attach_config = D('Admin/SystemData')->get('system:attach_config');
		
		$info = $this->upload($attach_config);
		
		if($info['status']){
			$data = $info['info'][0];
			/*
			if($thumb==1){
				$data['src'] = getImageUrl($data['savepath'].$data['savename'],$width,$height,$cut);
			}else{
				$data['src'] = $data['savepath'].$data['savename'];
			}
			*/
			$data['src'] = $attach_config['rootPath'].$data['savepath'].$data['savename'];
			$data['src'] = ltrim($data['src'], '.');
			$data['extension']  = strtolower($data['ext']);
			$return = array('status'=>1,'data'=>$data);
		}else{
			$return = array('status'=>0,'data'=>$info['info']);
		}
		echo json_encode($return);exit();
	}
	
	/**
	 * 上传附件
	 * @param array config 附件配置信息
	 * @param upload 上载主体
	 * @return array 上传的附件的信息
	 */
	public function upload ($config) {
		if ($attach_config['cloud']){
		}else{
			$info = $this->_localupload($config);
		}
		
		return $info;
	}
	
	public function down(){
		$aid = I('get.attach_id');
		$attach = D('Attach/Attach')->find($aid);
		if (!$attach){
			die(L('PUBLIC_ATTACH_ISNULL'));
		}
		
		$filename = $attach['filepath'].$attach['savename'];
		$realname = auto_charset($attach['name'], 'UTF-8', 'GBK//IGNORE');
		
		if(file_exists($filename)){
			Http::download($filename, $realname);
		}else{
			die(L('PUBLIC_ATTACH_ISNULL'));
		}
	}
	
	private function _localupload ($config) {
		
		// ThinkPHP Upload.class.php
		$upload = new Upload($config);
		
		// 执行上传操作
		$attachinfos = $upload->upload();
		
		if (!$attachinfos){
			$ret['status'] = false;
			$ret['info']   = $upload->getError();
		}else{
			
			// 保存$upload->upload(), 到数据库中。
			$data = $this->_saveAttachinfo($attachinfos, $upload);
			
			$ret['status'] = true;
			$ret['info']   = $data;
		}
		return $ret;
	}
	
	private function _saveAttachinfo(&$attachinfos, &$upload) {
		
		foreach($attachinfos as $k => $v){
			if (isset($v['name'])){
				$data['name'] = $v['name'];
			}
			if (isset($v['type'])){
				$data['type'] = $v['type'];
			}
			if (isset($v['size'])){
				$data['size'] = $v['size'];
			}
			if (isset($v['ext'])){
				$data['ext'] = $v['ext'];
			}
			if (isset($v['md5'])){
				$data['md5'] = $v['md5'];
			}
			if (isset($v['savename'])){
				$data['savename'] = $v['savename'];
			}
			
			$data['savepath'] = $v['savepath'];
			
			$data['filepath'] = $upload->rootPath.$v['savepath'];
			
			$data['ctime'] = time();
			
			$res = D('Attach/Attach')->add($data);
			if ($res){
				$attachinfos[$k]['attach_id'] = intval($res);
			}
			$infos[] = $attachinfos[$k];
		}
		return $infos;
	}
	
	private function _remoteupload () {
		
	}
	
	private function _assignVar ($data){
		$var = array();
		$var['callback']    = isset($data['callback'])? $data['callback'] : "''";
		$var['uploadType']  = isset($data['uploadType'])? $data['uploadType'] : 'file';
		$var['inputname']   = isset($data['inputname'])? $data['inputname'] : 'attach';
		$var['attachIds']   = isset($data['attachIds'])? $data['attachIds'] : "''";
		$var['inForm']      = isset($data['inForm'])? $data['inForm'] : 1;
		$var['limit']       = isset($data['limit'])? $data['limit'] : 1;
		
		if ($var['attachIds'] != ''){
			$aids = explode('|', $var['attachIds']);
			$aids = array_filter($aids);
			$attach = D('Attach/Attach')->getAttachByIds($aids);
			if($attach){
				$this->assign('attachInfo', $attach);
			}
		}
		
		$this->assign('callback', $var['callback']);
		$this->assign('uploadType', $var['uploadType']);
		$this->assign('inputname', $var['inputname']);
		$this->assign('attachIds', $var['attachIds']);
		$this->assign('limit', $var['limit']);
		$this->assign('inForm', $var['inForm']);
	}
}