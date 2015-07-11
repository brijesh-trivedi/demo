<?php

if ( !defined('BASEPATH') )
	exit('No direct script access allowed');

class My_Controller extends CI_Controller {

	// Layout set..
	protected $layout = 'layout';

	// Dynamic content..
	protected function render($content) {
		// Load helper..
		$this->load->helper('breadcrum_helper');
		$view_data = array(
			'content' => $content,
		);
		$this->load->view($this->layout, $view_data);
	}

}
