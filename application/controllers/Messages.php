<?php

if ( !defined('BASEPATH') )
	exit('No direct script access allowed');

class Messages extends My_Controller {

	/**
	 * index method
	 */
	public function index() {
		$content = $this->load->view('Messages/index', null, true);
		$this->render($content);
	}	
}

/* End of file Messages.php */
/* Location: ./application/controllers/Messages.php */