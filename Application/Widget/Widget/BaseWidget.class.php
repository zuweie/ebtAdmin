<?php
namespace Widget\Widget;
use Common\Controller\MyController;

abstract class BaseWidget extends MyController {
	abstract function render($data); 
}