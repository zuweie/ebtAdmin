<?php
namespace User\Model;
use Common\Model\MyModel;

class GroupPrivilegeModel extends MyModel {
	protected $tablenName = 'group_privilege';
	protected $fields     = array(0=>'id', 1=>'gid', 2=>'privilege');
}