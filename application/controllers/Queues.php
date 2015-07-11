<?php

if ( !defined('BASEPATH') )
	exit('No direct script access allowed');

class Queues extends My_Controller {

	/**
	 * Class Constructor method
	 */
	protected $senderStatus;
	protected $messageId;

	public function __construct(){
		parent::__construct();
		$this->load->model("campaigns_model");
		$this->load->model("queues_model");
		$this->load->model("sender_model");
    }
	/**
	 * index method
	 */
	public function index() {
		$content = $this->load->view('Queues/index', null, true);
		$this->render($content);
	}

	public function executeCampaign($campaign_id)
	{
		$queueData = $this->queues_model->getQueueDetailsForCampaign($campaign_id,true);
		/*send message to each recipient and updated their status in database*/
		foreach ($queueData as $key => $value) {
			$params = array('number' => $value->sender_number, 'nickname' => $value->nickname,'debug'=>false);
			
	        $this->load->library('whatsapp_lib',$params);
	        $this->whatsapp_lib->connect_with_proxy($value->proxy_ip,$value->proxy_port,$value->proxy_username,$value->proxy_password);
	        
	        /*Check sender status*/

		    $events = new MyEvents($this->whatsapp_lib);
	        $this->whatsapp_lib->eventManager()->bind("onLoginFailed", array($this,"onLoginFailed"));
	        $this->whatsapp_lib->eventManager()->bind("onLoginSuccess", array($this,"onLoginSuccess"));
            $this->whatsapp_lib->LoginWithPassword($value->wpassword);

            if($this->senderStatus=='InActive'){
                $this->queues_model->updateQueue( array('id' => $value->queue_id,'message_id'=> (string)$response,'status'=> QUEUE_IN_PROGRESS, 'updated_at'=> CURRENT_DATE_TIME));
            }
            elseif($this->senderStatus == 'Active'){
                /*Call Saperate methods based on Message Type*/
		        $response = "";
		        switch ($value->message_type) {
		        	case 'Text':
		        		$this->whatsapp_lib->eventManager()->bind("onSendMessage", array($this,"onSendMessage"));
		        		$response = $this->whatsapp_lib->sendMessage($value->recipient_number, $value->message_data);	
		        		$this->messageId = $response;
		        		break;
		        	case 'Image':
		        		$response = $this->whatsapp_lib->sendMessageImage($value->recipient_number, $value->message_data, null, false, 0, null, null);
		        		$this->messageId = $response;
		        		break;
		        	case 'Video':
		        		$response = $this->whatsapp_lib->sendMessageVideo($value->recipient_number, $value->message_data, null, false, 0, null, null);	
		        		$this->messageId = $response;
		        		break;
		        	case 'Audio':
		        		$response = $this->whatsapp_lib->sendMessageAudio($value->recipient_number, $value->message_data);	
		        		$this->messageId = $response;
		        		break;
		        	case 'Location':
		        		$response = $this->whatsapp_lib->sendMessageLocation($value->recipient_number, $value->message_data);	
		        		$this->messageId = $response;
		        		break;
		        	case 'Contact':
		        		$message_data = json_decode($value->message_data,true);
		        		$vcard = $this->whatsapp_lib->creatVCard($message_data);
		        		$contact_name =  $message_data['contact_name'];
		        		$response = $this->whatsapp_lib->sendVcard($value->recipient_number, $contact_name, $vcard);	
		        		$this->messageId = $response;
		        		break;
		        	default:
		        		# code...
		        		break;
		        }
		        /*Update the queue upon message sent*/
		        if($response){
		        	$this->queues_model->updateQueue( array('id' => $value->queue_id,'message_id'=> $this->messageId,'status'=> QUEUE_COMPLETE, 'updated_at'=> CURRENT_DATE_TIME));
		        	$this->sender_model->update( array('id' => $value->sender_id,'last_sent_on'=> CURRENT_DATE_TIME));
		        }
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
			$this->session->set_flashdata('error', 'Campaign execution pending.');	

		}
	}
	
	public function processQueue($campaign_id=""){
		
		$shell_command = "php index.php Queues executeCampaign $campaign_id > /dev/null 2>/dev/null &";
		shell_exec($shell_command);
		
		$this->campaigns_model->updateCampaign(array('id'=> $campaign_id,'status'=>CAMPAIGN_PENDING, 'updated_at'=> CURRENT_DATE_TIME));
		$this->session->set_flashdata('success', 'Campaign execution progressing in background.');	

		redirect('Campaigns/index');
	}
	public function onLoginFailed($mynumber,$data){
      $this->senderStatus='InActive';
    }

    public function onLoginSuccess($mynumber, $kind, $status, $creation, $expiration){
       $this->senderStatus='Active';
    }
    public function onSendMessage($mynumber, $target, $messageId, $node){
    	$this->messageId = $messageId;
    }
    public function onMediaMessageSent( $mynumber, $to, $id, $filetype, $url, $filename, $filesize, $filehash, $caption, $icon ){
    	$this->messageId = $id;
    }
        
   

}

/* End of file Queues.php */
/* Location: ./application/controllers/Queues.php */