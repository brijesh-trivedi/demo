<?php

if ( !defined('BASEPATH') )
	exit('No direct script access allowed');

class Messages extends My_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("message_model");
    }
	/**
	 * index method
	 */
	public function index()
    {
        $data['messageData'] = $this->message_model->get();
        $data['messageStats'] = $this->message_model->get_message_stats();
		$content = $this->load->view('Messages/index', $data, true);
		$this->render($content);
	}	
}

/* End of file Messages.php */
/* Location: ./application/controllers/Messages.php */