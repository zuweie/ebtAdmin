<?php
namespace Doc\Controller;
use Admin\Controller\AdministratorController;
use Admin\Controller\LeftMenuInterface;

class AdminController extends AdministratorController
					   implements LeftMenuInterface{
	
	public function leftMenu(){
		$leftMenu['title'] = L('DOC_ADMIN_TITLE');
		$leftMenu['id'] = 'doc';
		$leftMenu['submenu'][] = array('title'=>L('DOC_ADMIN_LIST'), 'id'=>'1', 'url'=>U('Doc/Admin/index'));
		$leftMenu['submenu'][] = array('title'=>L('DOC_ADMIN_CONFIG'), 'id'=>'2', 'url'=>U('Doc/Admin/config'));
		$leftMenu['submenu'][] = array('title'=>L('DOC_FlEXPAPER_CONFIG'), 'id'=>'3', 'url'=>'/Application/Doc/FlexPaper/php/setup.php');
  		echo json_encode($leftMenu);
		return true;
	}
	
	public function index () {
		$this->pageTab[] = array('title'=>L('DOC_ADMIN_LIST'), 'tabHash'=>'index', 'url'=>U('Doc/Admin/index'));
		$this->pageTab[] = array('title'=>L('DOC_ADMIN_ADD'), 'tabHash'=>'addDoc', 'url'=>U('Doc/Admin/addDoc'));
		$this->_listpk = 'd_id';
		$this->pageButton[] = array('title'=>L('DOC_ADMIN_CONVERT_2_PDF'), 'onclick'=>'doc.convert2pdf();');
		$this->pageKeyList = array('d_id', 'd_title', 'd_attach_id', 'd_desc','name', 'savename', 'display','DOACTION');
		$listData = D('Doc/Doc')->getDocList();
		$this->displayList($listData);
	}
	
	public function addDoc () {
		$this->pageTab[] = array('title'=>L('DOC_ADMIN_LIST'), 'tabHash'=>'index', 'url'=>U('Doc/Admin/index'));
		$this->pageTab[] = array('title'=>L('DOC_ADMIN_ADD'), 'tabHash'=>'addDoc', 'url'=>U('Doc/Admin/addDoc'));
		$this->pageKeyList = array('title', 'attach', 'desc');
		$this->savePostUrl = U('Doc/Admin/doAddDoc');
		$this->displayConfig();
	}
	
	public function doAddDoc () {
		$data['title'] = I('post.title', null);
		$data['attach'] = I('post.attach_ids', null);
		
		if (isset($data['attach'])){
			$aids = explode('|', $data['attach']);
			$aids = array_filter($aids);
			if ($aids){
				$data['attach'] = array_pop($aids);
			}
		}
		
		$data['desc'] = I('post.desc', null);
		$data['ctime'] = time();
		$res = D('Doc/Doc')->add($data);
		if (!res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), U('Doc/Admin/index'));
		}
	}
	
	public function config() {
		$this->pageTab[] = array('title'=>L('DOC_ADMIN_CONFIG'), 'tabHash'=>'config', 'url'=>U('Doc/Admin/config'));
		$this->savePostUrl = U('Doc/Admin/doConfig');
		$this->pageKeyList = array('ext', '_converter', 'cmd', 'output');
		$this->opt['_converter'] = array(0=>'no', 1=>'yes');
		$config = D('Admin/SystemData')->get('doc:config');
		$this->displayConfig($config);
	}
	
	public function doConfig () {
		$data['ext'] = I('post.ext', null);
		$data['cmd'] = I('post.cmd', null);
		$data['output'] = I('post.output', null);
		$data['_converter'] = I('post._converter', null);
		$lk = 'doc:config';
		$res = D('Admin/SystemData')->put($lk, $data);
		if (!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), U('Doc/Admin/config'));
		}
	}
	
	public function convert2Pdf () {
	
		$ids = I('post.ids');
		$doc = D('Doc/Doc')->getDocByIds($ids);
		if (!$doc){
			$this->ajaxReturnJson(0, L('ERR_DOC_NO_EXISTS'));
		}else{
			// DO the convert
			$config = D('Admin/SystemData')->get('doc:config');
				
			foreach($doc as $d){
				$ext = strtolower($d['ext']);
				if ($ext != 'pdf' && (empty($config['ext']) ? true : strpos($config['ext'], $ext) !== false )){
					$dealfile[] = $d['filepath'].$d['savename'];
				}
			}
			
			if (is_array($dealfile) && count($dealfile) > 0){
				
				if (intval($config['_converter']) !== 0){
					// use the third converter
					$cmd = $config['cmd'];
					$input = '';
					foreach ($dealfile as $f){
						$input .= ' '.$f.' ';
					}
					$ouput = $config['output'];
					$exec_str = str_replace('{OUTPUT}', $output, str_replace('{INPUT}', $input, $cmd));
				
				}else if (file_exists(MODULE_PATH.'Converter/jodconverter-core-3.0-beta-4.jar')){
				
					$exec_str = 'java -jar '.MODULE_PATH.'Converter/jodconverter-core-3.0-beta-4.jar';
					$exec_str .= ' -o pdf ';
					foreach ($dealfile as $f){
						$exec_str .= ' '.$f.' ';
					}
				
				}else{
					$this->ajaxReturnJson(0, L('ERR_CONVERTER_NO_EXISTS'));
				}
					
				$line = system($exec_str, $retval);
				if ($retval !== 0){
					$this->ajaxReturnJson(0, L('ERR_DOC_CONVERT_FAIL'));
				}else if ($retval === 0){
					$this->ajaxReturnJson(1, L('MSG_DOC_CONVERT_SUCCESS'));
				}
			}else{
				// no file needed to convert
				$this->ajaxReturnJson(1, L('DOC_NO_NEED_TO_CONVERT'));
			}
		}
	}

}