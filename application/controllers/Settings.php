<?php

if ( !defined('BASEPATH') )
	exit('No direct script access allowed');

class Settings extends MY_UserController {

	/**
	 * index method
	 */
	public function index() {
		$content = $this->load->view('Settings/index', null, true);
		$this->render($content);
	}

}

/* End of file Settings.php */
/* Location: ./application/controllers/Settings.php */