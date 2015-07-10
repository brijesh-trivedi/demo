<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
	$params = array('number' => '15128173499', 'nickname' => '444555');
        $this->load->library('whatsapp_lib',$params);
        $porxy_response = $this->whatsapp_lib->connect_with_proxy("136.0.117.240","29842","saudalq","kU81Mxa0");
        echo "<pre>";
        var_dump($porxy_response);
        die;

		$this->load->view('welcome_message');

        /*$this->load->library('whatsapp_lib');
		$this->load->view('welcome_message');

		$this->whatsapp_lib->connect();*/
	}
}
