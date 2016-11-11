<?php
defined('BASEPATH') or exit('No direct script access allowed');
class MY_Loader extends CI_Loader{

	public function _construct(){
		parent::_construct();
	}

	public function view($view, $vars = array(), $layout='', $return = FALSE)
	{
		$layout=($layout=='')?config_item('layout'):$layout;
		$vars['contenido']=$this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => TRUE));
		return $this->_ci_load(array('_ci_view' => $layout, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
	}
}

  ?>