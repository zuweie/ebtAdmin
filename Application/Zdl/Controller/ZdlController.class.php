<?php
namespace Zdl\Controller;
use Common\Controller\MyController;

class ZdlController extends MyController {
	public function index(){
		$projects = D('Zdl/Project')->select();
		$this->assign('projects', $projects);
		$process = D('Zdl/process')->select();
		
		// group the process by projectid;
		foreach ($process as $p){
			$ppmap[$p['p_project']][] = $p;
		}
		$this->assign('pp', $ppmap);
		$this->display();
	}
	
	public function process() {
		$pid = I('get.id');
		$process = D('Zdl/process')->find($pid);
		$status = D('Zdl/process')->getProcessStatusKV();
		$process['status'] = $status[$process['p_status']];
		$this->assign('process', $process);
		$pcontext = unserialize($process['p_context']);
		$this->assign('context', $pcontext);
		$maindev = D('Zdl/Dev')->getProcessedMainDev($process['p_id']);
		$this->assign('maindev', $maindev);
		$project = D('Zdl/Project')->find($process['p_project']);
		$this->assign('project', $project);
		$this->display();
	}
	
	public function repairationlist() {
		$pid = I('get.pid');
		$task = D('Zdl/Task')->getTaskByProcessId($pid);
		$this->assign('pid', $pid);
		$this->assign('task', $task['data']);
		$this->display();
	}
	
	public function addRepairationRecord() {
		$pid = I('get.pid');
		$tid = I('get.tid');
		$process = D('Zdl/Process')->getProcessById($pid);
		$this->assign('process', $process);
		$this->assign('pid', $pid);
		if (!empty($tid)){
			$task = D('Zdl/Task')->find($tid);
			$this->assign('task', $task);
		}
		if (empty($tid)){
			$this->assign('save_url', U('Zdl/Zdl/doAddRepairationRecord'));
		}else {
			$this->assign('save_url', U('Zdl/Zdl/doEditRepairationRecord'));
		}
		$this->display();
	}
	
	public function doAddRepairationRecord() {
		$pid = I('post.pid');
		if (!empty($pid)){
			$data['t_title'] = I('post.t_title');
			$data['t_request'] = I('post.t_request');
			$data['t_response'] = I('post.t_response');
			$data['t_attention'] = I('post.t_attention');
			$data['t_date']  = time();
			$data['t_process'] = I('post.pid');
			$res = D('Zdl/Task')->add($data);
			if (!$res){
				$this->error(L('ERR_SAVE_FAIL'));
			}else{
				$this->success(L('MSG_SAVE_SUCCESS'), U('Zdl/Zdl/repairationlist', array('pid'=>$pid)));
			}
		}else{
			$this->error(L('ERR_SAVE_FAIL'));
		}
	}
	
	public function doEditRepairationrecord() {
		$tid = I('post.tid');
		$pid = I('post.pid');
		if (!empty($tid) && !empty($pid)){
			$data['t_title'] = I('post.t_title');
			$data['t_request'] = I('post.t_request');
			$data['t_response'] = I('post.t_response');
			$data['t_id'] = $tid;
			$res = D('Zdl/Task')->save($data);
			
			if (!$res){
				$this->error(L('ERR_SAVE_FAIL'));
			}else{
				$this->success(L('MSG_SAVE_SUCCESS'), U('Zdl/Zdl/repairationlist', array('pid'=>$pid)));
			}
		}else{
			$this->error(L('ERR_SAVE_FAIL'));
		}
	}
	
	public function delRepairationRecord() {
		$tid = I('get.tid');
		$pid = I('get.pid');
		if (!empty($tid)){
			$res = D('Zdl/Task')->delete($tid);
			if (!$res){
				$this->error(L('ERR_DEL_FAIL'), U('Zdl/Zdl/repairationlist', array('pid'=>$pid)));
			}else{
				$this->success(L('MSG_DEL_SUCCESS'), U('Zdl/Zdl/repairationlist', array('pid'=>$pid)));
			}
		}else{
			$this->error(L('ERR_DEL_FAIL'), U('Zdl/Zdl/repairationlist', array('pid'=>$pid)));
		}
	}
	
	public function repairationdetail () {
		$tid = I('get.tid');
		$pid = I('get.pid');
		$task = D('Zdl/Task')->find($tid);
		$this->assign('task', $task);
		$this->display();
	}
	
	public function machinelist() {
		$this->display();
	}
	
	public function machine() {
		$this->diaplay();
	}
}