<?php
namespace User\Model;
use Common\Model\MyModel;

class UserGroupModel extends MyModel {
	protected $tableName = 'user_group';
	protected $fields    = array(0=>'gid', 1=>'title', 2=>'uid', 3=>'status', 4=>'ctime');
	protected $pk        = 'gid';
	
}