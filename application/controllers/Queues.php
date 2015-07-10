<?php

if ( !defined('BASEPATH') )
	exit('No direct script access allowed');

class Queues extends My_Controller {

	/**
	 * Class Constructor method
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model("campaigns_model");
		$this->load->model("queues_model");
    }
	/**
	 * index method
	 */
	public function index() {
		$content = $this->load->view('Queues/index', null, true);
		$this->render($content);
	}
	
	public function processQueue($campaign_id){

		$queueData = $this->queues_model->getQueueDetailsForCampaign($campaign_id,true);
		/*send message to each recipient and updated their status in database*/
		foreach ($queueData as $key => $value) {
			$params = array('number' => $value->sender_number, 'nickname' => $value->nickname,'debug'=>false);
			
	        $this->load->library('whatsapp_lib',$params);
	        $this->whatsapp_lib->connect_with_proxy($value->proxy_ip,$value->proxy_port,$value->proxy_username,$value->proxy_password);
	        $this->whatsapp_lib->LoginWithPassword($value->wpassword);
	        /*Call Saperate methods based on Message Type*/
	        $response = "";
	        switch ($value->message_type) {
	        	case 'Text':
	        		$response = $this->whatsapp_lib->sendMessage($value->recipient_number, $value->message_data);	
	        		break;
	        	case 'Image':
	        		$response = $this->whatsapp_lib->sendMessageImage($value->recipient_number, $value->message_data, null, false, 0, null, null);
	        		break;
	        	case 'Video':
	        		$response = $this->whatsapp_lib->sendMessageVideo($value->recipient_number, $value->message_data, null, false, 0, null, null);	
	        		break;
	        	case 'Audio':
	        		$response = $this->whatsapp_lib->sendMessageAudio($value->recipient_number, $value->message_data);	
	        		break;
	        	case 'Location':
	        		$response = $this->whatsapp_lib->sendMessageLocation($value->recipient_number, $value->message_data);	
	        		break;
	        	
	        	default:
	        		# code...
	        		break;
	        }
	        /*Update the queue upon message sent*/
	        if($response){
	        	$this->queues_model->updateQueue( array('id' => $value->queue_id,'message_id'=> (string)$response,'status'=> QUEUE_COMPLETE, 'updated_at'=> CURRENT_DATE_TIME));
	        }

	        
		}

		/*update the campaign Details*/
		$campaignAfterQueueExecution = $this->queues_model->getQueueDetailsForCampaign($campaign_id,true);
		
		if(count($campaignAfterQueueExecution) == 0){
			/*Update the campaign table*/
			$this->campaigns_model->updateCampaign(array('id'=> $campaign_id,'status'=>CAMPAIGN_COMPLETE, 'updated_at'=> CURRENT_DATE_TIME));
			$this->session->set_flashdata('success', 'Campaign execution finished successfully.');	

		}else{
			$this->campaigns_model->updateCampaign(array('id'=> $campaign_id,'status'=>CAMPAIGN_PENDING, 'updated_at'=> CURRENT_DATE_TIME));
			$this->session->set_flashdata('success', 'Campaign execution pending.');	

		}
		redirect('Campaigns/index');

	}

}

/* End of file Queues.php */
/* Location: ./application/controllers/Queues.php */