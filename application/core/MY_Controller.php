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
class My_UserController extends My_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->checkLogin();
   
 }
 function checkLogin()
 {
     $this->load->model('user_model','',TRUE); 
     $this->user_model->isLoggedin();
 }
 function logout()
 {
   $this->session->unset_userdata('logged_in');
   session_destroy();
   redirect('home', 'refresh');
 }
 
}
