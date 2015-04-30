<?php
namespace Zdl\Controller;
use Admin\Controller\AdministratorController;
use Admin\Controller\LeftMenuInterface;

class AdminController extends AdministratorController
					  implements LeftMenuInterface {
	
	public function leftMenu() {
		$leftMenu['title'] = L('ADMIN_ZDL_LEFTMENU_TITLE');
		$leftMenu['id']    = 'zdl';
		$leftMenu['submenu'][] = array('title'=>L('ADMIN_ZDL_INDEX'), 'id'=>1, 'url'=>U('Zdl/Admin/index'));
		//$leftMenu['submenu'][] = array('title'=>L('ADMIN_ZDL_PROJECT'), 'id'=>2, 'url'=>U('Zdl/Admin/project'));
		//$leftMenu['submenu'][] = array('title'=>L('ADMIN_ZDL_TYPE'), 'id'=>3, 'url'=>U('Zdl/Admin/type'));
		//$leftMenu['submenu'][] = array('title'=>L('ADMIN_ZDL_STATUS'), 'id'=>4, 'url'=>U('Zdl/Admin/status'));
		$leftMenu['submenu'][] = array('title'=>L('ADMIN_ZDL_PROCESS'), 'id'=>5, 'url'=>U('Zdl/Admin/process'));
		$leftMenu['submenu'][] = array('title'=>L('ADMIN_ZDL_PROJECT'), 'id'=>6, 'url'=>U('Zdl/Admin/project'));
		echo json_encode($leftMenu);
		exit;
	}
		
	public function index() {
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_INDEX'), 'tabHash'=>'index', 'url'=>U('Zdl/Admin/index'));
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_ADDDEV'), 'tabHash'=>'addDev', 'url'=>U('Zdl/Admin/addDev'));
		$listData = D('Zdl/Dev')->getDevList(20);
		$this->pageKeyList = array('dev_name', 'dev_zbh', 'dev_bah', 'dev_cch', 'type', 'specification','model', 'brand', 'dev_process', 'mainbody','DOACTION');
		$this->displayList($listData);
	}
	
	public function addDev() {
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_INDEX'), 'tabHash'=>'index', 'url'=>U('Zdl/Admin/index'));
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_ADDDEV'), 'tabHash'=>'addDev', 'url'=>U('Zdl/Admin/addDev'));
		$this->pageKeyList = array('dev_name', 'dev_type', 'dev_zbh', 'dev_bah', 'dev_cch', 'specification', 'model', 'brand', 'mainbody');
		$this->opt['dev_type'] = D('Zdl/Dev')->getDevType();
		$this->opt['specification'] = array('80'=>'80', '100'=>'100', '63'=>'63');
		$this->opt['model'] = array('5013'=>'5013', '5613'=>'5613', '6012'=>'6012');
		$this->opt['brand'] = array('五羊'=>'五羊', '聚龙'=>'聚龙', '中联'=>'中联');
		$this->opt['mainbody'] = array('1'=>'是', '0'=>'否');
		$this->savePostUrl = U('Zdl/Admin/doAddDev');
		$this->displayConfig();
	}
	
	public function doAddDev() {
		$data['dev_name'] = I('post.dev_name', null);
		$data['dev_zbh']  = I('post.dev_zbh', null);
		$data['dev_bah']  = I('post.dev_bah', null);
		$data['dev_cch']  = I('post.dev_cch', null);
		$data['dev_type'] = I('post.dev_type', null);
		$attr['specification'] = I('post.specification');
		$attr['model'] = I('post.model');
		$attr['brand'] = I('post.brand');
		$data['dev_attr'] = serialize($attr);
		$data['dev_process'] = I('post.dev_process', -1);
		$data['dev_mainbody'] = I('post.mainbody');
		$res = D('Zdl/Dev')->add($data);
		
		if(!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), U('Zdl/Admin/index'));
		}
	}
	
	public function editDev() {
		$id = I('get.id');
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_INDEX'), 'tabHash'=>'index', 'url'=>U('Zdl/Admin/index'));
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_EDITDEV'), 'tabHash'=>'editDev', 'url'=>U('Zdl/Admin/editDev', array('id'=>$id)));
		$dev = D('Zdl/Dev')->find($id);
		$attr = unserialize($dev['dev_attr']);
		$dev['specification'] = $attr['specification'];
		$dev['model'] = $attr['model'];
		$dev['brand'] = $attr['brand'];
		$this->pageKeyList = array('dev_id', 'dev_name', 'dev_type', 'dev_zbh', 'dev_bah', 'dev_cch','specification', 'model', 'brand', 'mainbody');
		$this->opt['specification'] = array('80'=>'80', '100'=>'100', '63'=>'63');
		$this->opt['model'] = array('5013'=>'5013', '5613'=>'5613', '6012'=>'6012');
		$this->opt['brand'] = array('五羊'=>'五羊', '聚龙'=>'聚龙', '中联'=>'中联');
		$this->opt['dev_type'] = D('Zdl/Dev')->getDevType();
		$this->opt['mainbody'] = array(0=>'否', 1=>'是');
		$this->savePostUrl = U('Zdl/Admin/doEditDEv');
		$this->displayConfig($dev);
	}
	
	public function doEditDev(){
		$id = I('post.dev_id');
		$data['dev_name'] = I('post.dev_name');
		$data['dev_zbh']  = I('post.dev_zbh');
		$data['dev_cch']  = I('post.dev_cch');
		$data['dev_bah']  = I('post.dev_bah');
 		$data['dev_type'] = I('post.dev_type');
 		$data['dev_mainbody'] = I('post.mainbody');
		$attr['specification'] = I('post.specification');
		$attr['model'] = I('post.model');
		$attr['brand'] = I('post.brand');
		$data['dev_attr'] = serialize($attr);
		$data['dev_id'] = $id;
		
		$res = D('Zdl/Dev')->save($data);
		
		if(!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), U('Zdl/Admin/index'));
		}
	}
	
	public function delDev() {
		$id = I('post.id');
		$res = D('Zdl/Dev')->delete($id);
		if(!$res){
			$this->ajaxReturnJson(0, L('ERR_DEL_FAIL'));
		}else{
			$this->ajaxReturnJson(1, L('MSG_DEL_SUCCESS'));
		}
	}
	
	// process
	public function process(){
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_PROCESS'), 'tabHash'=>'process', 'url'=>U('Zdl/Admin/process'));
		//$this->pageTab[] = array('title'=>L('ADMIN_ZDL_ADDPROCESS'), 'tabHash'=>'addProcess', 'url'=>U('Zdl/Admin/addProcess'));
		$proid = I('get.pro_id');
		if (!empty($proid)){
			$map['p_project'] = $proid;
			$listData = D('Zdl/Process')->getProcessList(20, $map);
		}else{
			$listData = D('Zdl/Process')->getProcessList();
		}
		$this->pageKeyList = array('p_id', 'p_title', 'p_maindev', 'maindev','p_project', 'p_context', 'status', 'p_opened', 'p_closed', 'DOACTION');
		$this->displayList($listData);
	}
	
	
	public function addProcess(){
		$projectid = I('get.pro_id');
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_PROCESS'), 'tabHash'=>'process', 'url'=>U('Zdl/Admin/process'));
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_ADDPROCESS'), 'tabHash'=>'addProcess', 'url'=>U('Zdl/Admin/addProcess'));
		$this->pageKeyList = array('p_title', 'maindev', 'pro_id', 'pro_title');
		$this->opt['maindev'] = D('Zdl/Dev')->getIdleMainDevKV();
		// TODO : get the project
		$this->savePostUrl = U('Zdl/Admin/doAddProcess');
		$data['pro_id'] = $projectid;
		$data['pro_title'] = I('get.pro_title');
		$this->displayConfig($data);
	}
	
	public function doAddProcess() {
		$projectid = I('post.pro_id');
		$maindev = I('post.maindev');
		if (!empty($projectid) && !empty($maindev)){
			// check main dev
			if (D('Zdl/Dev')->isProcessMainDevValid($maindev)){
				// ok set it 
				$data['p_title'] = I('post.p_title');
				$data['p_context'] = I('post.p_context');
				$data['p_project'] = I('post.pro_id');
				$data['p_maindev'] = $maindev;
				$data['p_status'] = 0;
				
				$new_processid = D('Zdl/Process')->add($data);
				
				if (!$new_processid){
					// failed
					$this->error(L('ERR_SAVE_FAIL'));
				}else{
					// process created ok
					unset($data);
					$data['dev_process'] = $new_processid;
					$data['dev_id'] = $maindev;
					$res = D('Zdl/Dev')->save($data);
					if (!$res){
						$this->error(L('ERR_SAVE_FAIL'));
					}else{
						$this->success(L('MSG_SAVE_SUCCESS'), U('Zdl/Admin/Process'));
					}
				}
			}else{
				$this->error(L('ERR_SAVE_FAIL'));
			}
		}else{
			$this->error(L('ERR_SAVE_FAIL'));
		}
	}
	
	public function editProcessInfo(){
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_PROCESS'), 'tabHash'=>'process', 'url'=>U('Zdl/Admin/process'));
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_EDITPROCESSINFO'), 'tabHash'=>'editProcessInfo', 'url'=>U('Zdl/Admin/editProcess'));
		$this->pageKeyList = array('p_id', 'p_title', 'p_context','p_status');
		$this->opt['p_status'] = D('Zdl/Process')->getProcessStatusKV();
		// TODO : get the project
		$id = I('get.id');
		$process = D('Zdl/Process')->find($id);
		$this->savePostUrl = U('Zdl/Admin/doEditProcessInfo');
		$this->displayConfig($process);
	}
	
	public function doEditProcessInfo() {
		$id = I('post.p_id');
		$data['p_title'] = I('post.p_title');
		$data['p_context'] = I('post.p_context');
		$data['p_status'] = I('post.p_status');
		$data['p_id'] = $id;
		
		if ($data['p_status'] == 1){
			// process get started
			$data['p_opened'] = time();
			$data['p_closed'] = 0;
		}else if ($data['p_status'] == 4){
			// process get closed
			$data['p_closed'] = time();
		}else if($data['p_status'] == 0){
			$data['p_opened'] = 0;
			$data['p_closed'] = 0;
		}
		
		$res = D('Zdl/Process')->save($data);
		if(!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), U('Zdl/Admin/process'));
		}
	}
	
	public function editProcessMainDev(){
		$processid = I('get.id');
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_PROCESS'), 'tabHash'=>'process', 'url'=>U('Zdl/Admin/process')); 
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_EDITPROCESSDEV'), 'tabHash'=>'editProcessMainDev', 'url'=>U('Zdl/Admin/editProcessMainDev', array('id'=>$id)));
		$this->pageKeyList = array('p_id', 'maindev');
		$devs = D('Zdl/Dev')->getIdleMainDevKV();
		$maindev = D('Zdl/Dev')->getProcessedMainDev($processid);
		if (!empty($maindev)){
			$devs[$maindev['dev_id']] = $maindev['dev_zbh'].'('.$maindev['dev_id'].')';
		}
		$devs['-1'] = 'NAN';
		$this->opt['maindev'] = $devs;
		$data['p_id'] = $processid;
		$data['maindev'] = $maindev['dev_id'];
		$this->savePostUrl = U('Zdl/Admin/doEditProcessMainDev');
		$this->displayConfig($data);
	}
	
	public function doEditProcessMainDev(){
		$processid = I('post.p_id');
		$new_devid = I('post.maindev');
		$old_dev = D('Zdl/Dev')->getProcessedMainDev($processid);
		
		if (!empty($old_dev) && $new_devid != $old_dev['dev_id']) {
			// set the old main dev process to -1;
			$data['dev_process'] = -1;
			$data['dev_id'] = $old_dev['dev_id'];
			$res = D('Zdl/Dev')->save($data);
			
			if(!$res){
				$this->error(L('ERR_SAVE_FAIL'));
			}else if($new_devid >0){
				// update success
				
				unset($data);
				$data['dev_id'] = $new_devid;
				$data['dev_process'] = $processid;
				
				$res = D('Zdl/Dev')->save($data);
				if (!$res){
					$this->error(L('ERR_SAVE_FAIL'));
				}else{
					
					/* update p_maindev */
					unset($data);
					$data['p_id'] = $processid;
					$data['p_maindev'] = $new_devid;
					$res = D('Zdl/Process')->save($data);
					/* update p_maindev */
					
					$this->success(L('MSG_SAVE_SUCCESS'), U('Zdl/Admin/process'));
				}
			}else{
				$this->success(L('MSG_SAVE_SUCCESS'), U('Zdl/Admin/process'));
			}
		}else if (empty($old_dev)){
			unset($data);
			$data['dev_id'] = $new_devid;
			$data['dev_process'] = $processid;
			
			$res = D('Zdl/Dev')->save($data);
			if (!$res){
				$this->error(L('ERR_SAVE_FAIL'));
			}else{
				
				/* update p_maindev*/
				unset($data);
				$data['p_id'] = $processid;
				$data['p_maindev'] = $new_devid;
				$res = D('Zdl/Process')->save($data);
				
				$this->success(L('MSG_SAVE_SUCCESS'), U('Zdl/Admin/process'));
			}
		}else{
			$this->error(L('ERR_SAVE_FAIL'));
		}
	}
	
	public function delProcess(){
		$processid = I('post.id');
		D('Zdl/Dev')->removeProcessDev($processid);
		$res = D('Zdl/Process')->delete($processid);
		if(!$res){
			$this->ajaxReturnJson(0, L('ERR_DEL_FAIL'));
		}else{
			$this->ajaxReturnJson(1, L('MSG_DEL_SUCCESS'));
		}
	}
	// end process
	
	// project
	public function project() {
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_PROJECT'), 'tabHash'=>'project', 'url'=>U('Zdl/Admin/project'));
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_ADDPROJECT'), 'tabHash'=>'addProject', 'url'=>U('Zdl/Admin/addProject'));
		$this->pageKeyList = array('pro_id', 'pro_title', 'pro_addr', 'status', 'pro_opened', 'pro_closed', 'DOACTION');
		$listData = D('Zdl/Project')->getProjectList();
		$this->displayList($listData);
	}
	
	public function addProject() {
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_PROJECT'),'tabHash'=>'project', 'url'=>U('Zdl/Admin/project'));
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_ADDPROJECT'),'tabHash'=>'addProject', 'url'=>U('Zdl/Admin/addProject'));
		$this->pageKeyList = array('pro_title', 'pro_addr');
		//$this->opt['pro_status'] = D('Zdl/Project')->getProjectStatus();
		$this->savePostUrl = U('Zdl/Admin/doAddProject');
		$this->displayConfig();
	}
	
	public function doAddProject() {
		$data['pro_title'] = I('post.pro_title');
		$data['pro_addr']  = I('post.pro_addr');
		$data['pro_status'] = 0;
		$res = D('Zdl/Project')->add($data);
		if(!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), U('Zdl/Admin/project'));
		}
	}
	
	public function editProject(){
		$proid = I('get.id');
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_PROJECT'), 'tabHash'=>'project', 'url'=>U('Zdl/Admin/project'));
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_EDITPROJECT'), 'tabHash'=>'editProject', 'url'=>U('Zdl/Admin/editProject', array('id'=>$proid)));
		$this->pageKeyList = array('pro_id','pro_title', 'pro_addr', 'pro_status');
		$this->opt['pro_status'] = D('Zdl/Project')->getProjectStatus();
		$this->savePostUrl = U('Zdl/Admin/doEditProject');
		$project = D('Zdl/Project')->find($proid);
		$this->displayConfig($project);
	}
	
	public function doEditProject() {
		$proid = I('post.pro_id');
		$data['pro_status'] = I('post.pro_status');
		if (!empty($data['pro_status']) && $data['pro_status'] == 1){
			$data['pro_opened'] = time();
			$data['pro_closed'] = 0;
		}else if (!empty($data['pro_status']) && $data['pro_status'] == 4){
			$data['pro_closed'] = time();
		}
		
		$data['pro_title'] = I('post.pro_title');
		$data['pro_addr']  = I('post.pro_addr');
		$data['pro_id'] = $proid;
		$res = D('Zdl/Project')->save($data);
		if(!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), U('Zdl/Admin/project'));
		}
	}
	
	public function delProject(){
		$proid = I('post.id');
		$res = D('Zdl/Process')->removeProjectProcess($proid);
		$res = D('Zdl/Project')->delete($proid);
		if(!$res){
			$this->ajaxReturnJson(0, L('ERR_DEL_FAIL'));
		}else{
			$this->ajaxReturnJson(1, L('MSG_DEL_SUCCESS'));
		}
	}
	
	// end project
	
	// type
	public function type() {
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_TYPE'), 'tabHash'=>'type', 'url'=>U('Zdl/Admin/type'));
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_ADDTYPE'), 'tabHash'=>'addType', 'url'=>U('Zdl/Admin/addType'));
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_EDITTYPE'), 'tabHash'=>'editType', 'url'=>U('Zdl/Admin/editType'));
		
		$listData = D('Zdl/Type')->getTypeList();
		$this->pageKeyList = array('ty_name', 'ty_code', 'DOACTION');
		$this->displayList($listData);
	}
	
	public function addType() {
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_TYPE'), 'tabHash'=>'type', 'url'=>U('Zdl/Admin/type'));
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_ADDTYPE'), 'tabHash'=>'addType', 'url'=>U('Zdl/Admin/addType'));
		
		$this->pageKeyList = array('ty_name', 'ty_code');
		$this->savePostUrl = U('Zdl/Admin/doAddType');
		$this->displayConfig();
	}
	
	public function doAddType () {
		
		$data['ty_name'] = I('post.ty_name', null);
		$data['ty_code'] = I('post.ty_code', null);
		
		$res = D('Zdl/Type')->add($data);
		
		if(!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), U('Zdl/Admin/type'));
		}
	}
	
	public function editType() {
		$id = I('get.id');
		$type = D('Zdl/Type')->find($id);
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_TYPE'), 'tabHash'=>'type', 'url'=>U('Zdl/Admin/type'));
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_EDITTYPE'), 'tabHash'=>'editType', 'url'=>U('Zdl/Admin/editType', array('id'=>$type['ty_id'])));
		$this->pageKeyList = array('ty_id', 'ty_name', 'ty_code');
		$this->savePostUrl = U('Zdl/Admin/doEditType');
		$this->displayConfig($type);
	}
	
	public function doEditType() {
		$id = I('post.ty_id');
		$data['ty_name'] = I('post.ty_name');
		$data['ty_code'] = I('post.ty_code');
		$data['ty_id'] = $id;
		$res = D('Zdl/Type')->save($data);
		
		if(!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), U('Zdl/Admin/type'));
		}
	}
	
	public function delType() {
		if (!is_null(I('post.id'))){
			$id = I('post.id');
			$res = D('Zdl/Type')->delete($id);
			
			if(!$res){
				$this->ajaxReturnJson(0, L('ERR_DEL_FAIL'));
			}else{
				$this->ajaxReturnJson(1, L('MSG_DEL_SUCCESS'));
			}	
		}else{
				$this->ajaxReturnJson(0, L('ERR_DEL_FAIL'));
		}
	}
	// end type
	
	// status 
	public function status() {
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_STATUS'), 'tabHash'=>'status', 'url'=>U('Zdl/Admin/status'));
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_ADDSTATUS'), 'tabHash'=>'addStatus', 'url'=>U('Zdl/Admin/addStatus'));
		
		$this->pageKeyList = array('s_id', 's_name', 's_code', 'createdAt', 'updatedAt', 'DOACTION');
		$listData = D('Zdl/Status')->getStatusList();
		$this->displayList($listData);
	}
	
	public function addStatus () {
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_STATUS'), 'tabHash'=>'status', 'url'=>U('Zdl/Admin/status'));
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_ADDSTATUS'), 'tabHash'=>'addStatus', 'url'=>('Zdl/Admin/addStatus'));
		
		$this->pageKeyList = array('s_name', 's_code');
		$this->savePostUrl = U('Zdl/Admin/doAddStatus');
		$this->displayConfig();
	}
	
	public function doAddStatus () {
		$data['s_name'] = I('post.s_name');
		$data['s_code'] = I('post.s_code');
		
		if (D('Zdl/Status')->isStatusValid($data['s_code'])){
			// save the status
			$res = D('Zdl/Status')->add($data);
			if(!$res){
				$this->error(L('ERR_SAVE_FAIL'));
			}else{
				$this->success(L('MSG_SAVE_SUCCESS'), U('Zdl/Admin/status'));
			}
		}else{
			$this->error(L('ERR_SAVE_FAILE'));
		}
	}
	
	public function editStatus () {
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_STATUS'), 'tabHash'=>'status', 'url'=>U('Zdl/Admin/status'));
		$this->pageTab[] = array('title'=>L('ADMIN_ZDL_STATUS'), 'tabHash'=>'editStatus', 'url'=>U('Zdl/Admin/editStatus'));
		
		$this->pageKeyList = array('s_id','s_name', 's_code');
		$this->savePostUrl = U('Zdl/Admin/doEditStatus');
		
		$id = I('get.id');
		$status = D('Zdl/Status')->find($id);
		
		$this->displayConfig($status);
	}
	
	public function doEditStatus () {
		$data['s_id'] = I('post.s_id');
		$data['s_name'] = I('post.s_name');
		$data['s_code'] = I('post.s_code');
		
		if (D('Zdl/Status')->isStatusValid($data['s_code'], $data['s_id'])){
			$res = D('Zdl/Status')->save($data);
			if(!$res){
				$this->error(L('ERR_SAVE_FAIL'));
			}else{
				$this->success(L('MSG_SAVE_SUCCESS'), U('Zdl/Admin/status'));
			}
		}else{
			$this->error(L('ERR_SAVE_FAIL'));
		}
	}
	
	public function delStatus() {
		
		$id = I('post.id');
		$res = D('Zdl/Status')->delete($id);
		
		if(!$res){
			$this->ajaxReturnJson(0, L('ERR_DEL_FAIL'));
		}else{
			$this->ajaxReturnJson(1, L('MSG_DEL_SUCCESS'));
		}	
	}
	// end status
}