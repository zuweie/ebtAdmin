<?php
namespace WeddingInvitation\Controller;
use Admin\Controller\AdministratorController;
use Admin\Controller\LeftMenuInterface;

class AdminController extends AdministratorController
					   implements LeftMenuInterface {
	
	public function leftMenu() {
		$leftMenu['title'] = '结婚请柬';
		$leftMenu['id']    = 'weddinginvitation';
		$leftMenu['submenu'][] = array('title'=>'请柬配置', 'id'=>'1', 'url'=>U('WeddingInvitation/Admin/config'));
		$leftMenu['submenu'][] = array('title'=>'嘉宾列表', 'id'=>'2', 'url'=>U('WeddingInvitation/Admin/index'));
		echo json_encode($leftMenu);
		exit;
	}
	
	public function index () {
		
		$this->pageTab[] = array('title'=>'嘉宾列表', 'tabHash'=>'index', 'url'=>U('WeddingInvitation/Admin/index'));
		$this->pageTab[] = array('title'=>'添加嘉宾', 'tabHash'=>'addGuest', 'url'=>U('WeddingInvitation/Admin/addGuest'));
		$this->pageKeyList = array('guest_id', 'name', 'title', 'people', 'desc','link', 'DOACTION');
		$uid = get_login_user_id();
		$map['uid'] = array('EQ',$uid);
		$listData = D('WeddingInvitation/Guest')->getGuestList(20, $map);
		$this->displayList($listData);
	}
	
	public function addGuest () {
		$this->pageTab[] = array('title'=>'嘉宾列表', 'tabHash'=>'index', 'url'=>U('WeddingInvitation/Admin/index'));
		$this->pageTab[] = array('title'=>'添加嘉宾', 'tabHash'=>'addGuest', 'url'=>U('WeddingInvitation/Admin/addGuest'));
		$this->pageKeyList = array('name', 'title', 'people', 'desc');
		$this->opt['title'] = array('miss'=>'女士', 'mr'=>'先生', 'couple'=>'伉俪');
		$this->savePostUrl = U('WeddingInvitation/Admin/doAddGuest');
		$this->displayConfig();
	}
	
	public function doAddGuest () {
		$data['name'] = I('post.name', null);
		$data['title'] = I('post.title', null);
		$data['people'] = I('post.people', 1);
		$data['desc'] = I('post.desc', null);
		$data['uid'] = get_login_user_id();
		$data['ctime'] = time();
		$res = D('WeddingInvitation/Guest')->add($data);
		if (!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), U('WeddingInvitation/Admin/index'));
		}
	}
	
	public function editGuest () {
		
		$id = I('get.id', null);
		$this->pageTab[] = array('title'=>'嘉宾列表', 'tabHash'=>'index', 'url'=>U('WeddingInvitation/Admin/index'));
		$this->pageTab[] = array('title'=>'编辑嘉宾', 'tabHash'=>'editGuest', 'url'=>U('WeddingInvitation/Admin/editGuest', array('id'=>'$id')));
		$this->pageKeyList = array('name', 'title', 'people','desc');
		$this->opt['title'] = array('miss'=>'女士', 'mr'=>'先生', 'couple'=>'夫妻');
		$this->savePostUrl = U('WeddingInvitation/Admin/doEditGuest');
		$guest = D('WeddingInvitation/Guest')->find($id);
		$this->displayConfig($guest);
	}
	
	public function doEditGuest () {
		$id = I('post.id', null);
		if ($id){
			$data['name'] = I('post.name', null);
			$data['title'] = I('post.title', null);
			$data['people'] = I('post.people', null);
			$data['desc'] = I('post.desc', null);
			$data['guest_id'] = $id;
			$res = D('weddingInvitation/Guest')->save($data);
			if (!$res){
				$this->error(L('ERR_SAVE_FAIL'));
			}else{
				$this->success(L('MSG_SAVE_SUCCESS'), U('WeddingInvitation/Admin/index'));
			}
		}else{
			$this->error(L('ERR_SAVE_FAIL'));
		}
	}
	
	public function delGuest () {
		$id = I('post.id', null);
		$res = D('WeddingInvitation/Guest')->delete($id);
		if (!$res){
			$this->ajaxReturnJson(0, L('ERR_DEL_FAIL'));
		}else{
			$this->ajaxReturnJson(1, L('MSG_DEL_SUCCESS'));
		}
	}
	
	public function config () {
		$this->pageTab[] = array('title'=>'请柬配置', 'tableHash'=>'config', 'url'=>'#');
		$this->pageKeyList = array('male', 'female', 'pic1', 'pic2', 'pic3',  'pic4', 'pic5', 'pic6', 'music', 'time', 'addr');
		$config = D('Admin/SystemData')->get('weddinginvitation:config');
		$this->savePostUrl = U('WeddingInvitation/Admin/doSaveConfig');
		$this->displayConfig($config);
	}
	
	public function doSaveConfig () {
		
		$data['male'] = I('post.male', null);
		$data['female'] = I('post.female', null);
		$data['pic4'] =  I('post.pic4_ids', null);
		$data['pic1'] = I('post.pic1_ids', null);
		$data['pic2'] = I('post.pic2_ids', null);
		$data['pic3'] = I('post.pic3_ids', null);
		$data['pic5'] = I('post.pic5_ids', null);
		$data['pic6'] = I('post.pic6_ids', null);
		$data['music'] = I('post.music_ids', null);
		$data['time'] = I('post.time', null);
		$data['addr'] = I('post.addr', null);
		
		$res = D('Admin/SystemData')->put('weddinginvitation:config', $data);
		
		if (!$res){
			$this->error(L('ERR_SAVE_FAIL'));
		}else{
			$this->success(L('MSG_SAVE_SUCCESS'), U('WeddingInvitation/Admin/config'));
		}
	}
}
