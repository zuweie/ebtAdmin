<?php
namespace Zdl\Model;
use Common\Model\MyModel;

class TaskModel extends MyModel {
	protected $tableName = 'task';
	protected $fields    = array(0=>'t_id', 1=>'t_title', 2=>'t_creater', 3=>'t_userid', 4=>'t_usergroup', 5=>'t_type', 6=>'t_request', 7=>'t_response',
								8=>'t_attention', 9=>'t_attach', 10=>'t_process', 11=>'t_dev', 12=>'t_date', 13=>'t_open', 14=>'t_close', 15=>'t_expct_close',
								16=>'t_act_sql', 17=>'t_status', 18=>'createAt', 19=>'updatedAt');
	protected $pk        = 't_id';
}