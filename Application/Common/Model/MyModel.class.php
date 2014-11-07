<?php
namespace Common\Model;
use Think\Model;
use Think\Page;
//use Vendor\Page;

class MyModel extends Model {
	
	/**
	 * 分页查询数据
	 * @access public
	 * @param mixed $options 表达式参数
	 * @param mixed $pageopt 分页参数
	 * @return mixed
	 */
	public function findPage($pageopt,$count=false,$options=array()){
		// 分析表达式
        $options =  $this->_parseOptions($options);
		// 如果没有传入总数，则自动根据条件进行统计
		if($count===false){
			// 查询总数
			$count_options		=	$options;
			$count_options['limit'] = 1;
			$count_options['field'] = 'count(1) as count';
			// 去掉统计时的排序提高效率
			unset($count_options['order']);
			$result =	$this->db->select($count_options);
            
			$count	=	$result[0]['count'];
			unset($result);
			unset($count_options);
		}
		// 如果查询总数大于0
		if($count > 0) {
			// 载入分页类
			//import('ORG.Util.Page');
			// 解析分页参数
			if( is_numeric($pageopt) ) {
				$pagesize	=	intval($pageopt);
			}else{
				$pagesize	=	intval(C('LIST_NUMBERS'));
			}
			
			$p = new Page($count,$pagesize);
			
			// 查询数据
			$options['limit']	=	$p->firstRow.','.$p->listRows;
			$resultSet	=	$this->select($options);

			if($resultSet){
				$this->dataList = $resultSet;
			}else{
				$resultSet	=	'';
			}

			// 输出控制
			$output['count']		=	$count;
			//$output['totalPages']	=	$p->totalPages;
			//$output['totalRows']	=	$p->totalRows;
			//$output['nowPage']		=	$p->nowPage;
			$output['html']			=	$p->show();
			$output['data']			=	$resultSet;
			unset($resultSet);
			unset($p);
			unset($count);
		}else{
			$output['count']		=	0;
			$output['totalPages']	=	0;
			$output['totalRows']	=	0;
			$output['nowPage']		=	1;
			$output['html']			=	'';
			$output['data']			=	'';
		}
		// 输出数据
		return $output;
     }
	
}