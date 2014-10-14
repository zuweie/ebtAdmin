<?php
namespace Widget\Widget;
use Think\Controller;

abstract class BaseWidget extends Controller {
	abstract function render($data); 
}