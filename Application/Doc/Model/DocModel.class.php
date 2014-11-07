<?php
namespace Doc\Model;
use Common\Model\MyModel;

class DocModel extends MyModel {
	
	protected $tableName = 'doc';
	protected $fields 	  = array(0=>'doc_id', 1=>'title', 2=>'attach',  3=>'desc', 4=>'ctime', '_pk'=>'doc_id');
	protected $pk     	  = 'doc_id';
	
	public function getDocList ($limit=20, $map=array()){
		
		$prefix = C('DB_PREFIX');
		
		$listData = $this->where($map)->field('`'.$prefix.'doc`.doc_id as d_id, `'.$prefix.'doc`.title as d_title, `'.$prefix.'doc`.attach as d_attach_id, `'.$prefix.'doc`.desc as d_desc, `'.$prefix.'doc`.ctime as d_ctime, `'.$prefix.'attach`.*')
									  ->join('LEFT JOIN `'.$prefix.'attach` ON `'.$prefix.'doc`.attach = `'.$prefix.'attach`.attach_id')->findPage($limit);
		
		foreach($listData['data'] as $k => $v){
			$basename = get_file_basename($v['savename']);
			if (strtolower($v['ext']) == 'pdf' || file_exists($v['filepath'].$basename.'.pdf')){
				$listData['data'][$k]['display'] = '<a href="'.U('Doc/Index/index', array('pdf'=>$basename.'.pdf')).'" target="_blank">'.$basename.'.pdf</a>';
			}
			if (!file_exists($v['filepath'].$v['savename'])){
				$listData['data'][$k]['savename'] = L('DOC_FILE_NO_EXISTS');
			}
		}
		
		return $listData;
	}
	
	public  function getDocByIds ($ids){
		if (is_numeric($ids)){
			$map['doc_id'] = array('EQ', $ids);
		}else if (is_array($ids)){
			$map['doc_id'] = array('IN', $ids);
		}else{
			return false;
		}
		
		$prefix = C('DB_PREFIX');
		
		$docs = $this->where($map)->field('`'.$prefix.'doc`.doc_id as d_id, `'.$prefix.'doc`.title as d_title, `'.$prefix.'doc`.attach as d_attach_id, `'.$prefix.'doc`.desc as d_desc, `'.$prefix.'doc`.ctime as d_ctime, `'.$prefix.'attach`.*')
					 ->join('LEFT JOIN `'.$prefix.'attach` ON `'.$prefix.'doc`.attach = `'.$prefix.'attach`.attach_id')
					 ->select();
		return $docs;
	}
}
