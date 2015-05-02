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
	
	public function machinelist() {
		$this->display();
	}
	
	public function machine() {
		$this->diaplay();
	}
}