<?php

if ( !defined('BASEPATH') )
	exit('No direct script access allowed');

class Campaigns extends My_Controller {

	/**
	 * Class Constructor method
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model("campaigns_model");
		$this->load->model("recipients_model");
		$this->load->model("queues_model");
		$this->load->model("sender_model");
    }

	/**
	 * index method
	 */
	public function index() {
		$data['campaignDetails'] = $this->campaigns_model->get();
		$content = $this->load->view('Campaigns/index', $data, true);
		$this->render($content);
	}

	/**
	 * ques_campaign method
	 */
	public function ques_campaign($campaign_id="") {
		if($campaign_id != ""){
			$data['queueDetails'] = $this->queues_model->getQueueDetailsForCampaign($campaign_id);
			$campaignDetails = $this->campaigns_model->get($campaign_id);
			$data['campaignName'] = $campaignDetails[0]->name;
			$data['campaign_id'] = $campaign_id;
		}
		$content = $this->load->view('Campaigns/ques_campaign', $data, true);
		$this->render($content);
	}
	public function campaignTest()
	{
		$total_target_numbers = '919925030968,919925030958,919925030959';
		//Logic to select Sender for every recipient
		$total_target_numbers = array_unique(explode(',', $total_target_numbers));
		$total_recipient_count = count($total_target_numbers);

		$senders = $this->sender_model->get();
		
		$total_sender_count = $this->sender_model->getTotalSenders();
		$total_sender_count = $total_sender_count[0]->totalSenders;
		

		$targets_per_sender = round($total_recipient_count / $total_sender_count);
        if ($targets_per_sender < 1) {
            $targets_per_sender = 1;
        }

        $start  = 0;
        $end    = $start + $targets_per_sender;
        $paired = 0;

       	for ($i = 0; $i < $total_sender_count; $i++) {
            for ($j = $start; $j < $end; $j++) {
            	if (@$total_target_numbers[$j]) {
                    $pairing[$senders[$i]->phone][$senders[$i]->id][] = $total_target_numbers[$j];
		            
                    $paired++;
                }
            }
            if ($total_sender_count > 1) {
                $start = $end;
                $end   = $start + $targets_per_sender;
            }
            
        }
        $diff = $total_recipient_count - $paired;
        if ($diff) {
        	$start = $paired;
            $end   = $start + 1;
            for ($i = 0; $i < $diff; $i++) {
                for ($j = $start; $j < $end; $j++) {
                    if ($total_target_numbers[$j]) {
                        $pairing[$senders[$i]->phone][$senders[$i]->id][] = $total_target_numbers[$j];
		                
                        $paired++;
                    }
                }
               
                if ($total_sender_count > 1) {
                    $start = $end;
                    $end   = $start + 1;
                }
            }
        }
        foreach($pairing as $key => $value){
			foreach ($value as $k => $val) {
				$queueData = array();
				$queueData['sender_number'] = $key; 
				$queueData['sender_id'] = $k; 
				$queueData['recipient_number'] = $val;
				$queueData['campaign_id'] = 1;
				$queueData['status'] = CAMPAIGN_WAITING;
				$queueData['updated_at'] = CURRENT_DATE_TIME;
				pr($queueData);
				//$queue = $this->queues_model->addQueue($queueData);
			}
		}	

        //pr($pairing);
        die;


	}
	/**
	 * add method
	 */
	public function add() {
	
		if($this->input->is_ajax_request()){
			
			
			$message_type = $this->input->post('message_type');
			$campaign_name = $this->input->post('name');
			$recipientList = $this->input->post('main_recipients');
			$text_message  = $this->input->post('text_message');
			$image  = $this->input->post('image');
			$video  = $this->input->post('video');
			$audio  = $this->input->post('audio');
			$contact  = $this->input->post('contact');
			$locationname  = $this->input->post('locationname');

			if($message_type == "text" && $text_message == ""){
				$this->form_validation->set_rules('text_message', 'Text', 'required|trim');
			}else if($message_type == "video" && $video == ""){
				$this->form_validation->set_rules('video', 'Video', 'required|trim');
			}else if($message_type == "audio" && $audio == ""){
				$this->form_validation->set_rules('audio', 'Audio', 'required|trim');
			}else if($message_type == "contact" && $contact == ""){
				$this->form_validation->set_rules("contact[contact_name]", 'Contact', 'required|trim');
				$this->form_validation->set_rules("contact[contact_number]", 'Contact', 'required|trim');
			}else if($message_type == "image" && $image == ""){
				$this->form_validation->set_rules('image', 'Image', 'required|trim');
			}else if($message_type == "location" && $locationname == ""){
				$this->form_validation->set_rules('location', 'Location', 'required|trim');
			}
			$this->form_validation->set_rules('main_recipients[]', 'Recipients', 'required|trim');

			if ($this->form_validation->run() == TRUE){
			
				$message_data = "";
				if($message_type == "text" && $text_message != ""){
					$message_data =  $text_message;
				}else if($message_type == "video" && $video != ""){
					$message_data =  $video;
				}else if($message_type == "audio" && $video != ""){
					$message_data =  $video;
				}else if($message_type == "contact" && $contact != ""){
					$contact = json_encode(array('contact_name'=>$contact['contact_name'], 'contact_number'=> $contact['contact_number']));
					$message_data =  $contact;
				}else if($message_type == "image" && $image != ""){
					$message_data =  $image;
				}else if($message_type == "location" && $locationname != ""){
					$message_data =  $locationname;
				}

				$campiagnInsertData = array();
				$campiagnInsertData['name'] = $campaign_name;	
				$campiagnInsertData['message_data'] = $message_data;
				$message_type = ucfirst($message_type);
				$campiagnInsertData['message_type'] = $message_type;
				$campiagnInsertData['status'] = CAMPAIGN_WAITING;
				$campiagnInsertData['scheduled_at'] = CURRENT_DATE_TIME;
				$campiagnInsertData['updated_at'] = CURRENT_DATE_TIME;

				// Add Campaign Details in to table.
				$campaign_id = $this->campaigns_model->addCampaign($campiagnInsertData);

				//Logic to select Sender for every recipient : Adopted from old Source
				
				$total_target_numbers = array_unique(explode(',', $recipientList));
				$total_recipient_count = count($total_target_numbers);

				$senders = $this->sender_model->get();
				
				$total_sender_count = $this->sender_model->getTotalSenders();
				$total_sender_count = $total_sender_count[0]->totalSenders;
				

				$targets_per_sender = round($total_recipient_count / $total_sender_count);
		        if ($targets_per_sender < 1) {
		            $targets_per_sender = 1;
		        }

		        $start  = 0;
		        $end    = $start + $targets_per_sender;
		        $paired = 0;

		       	for ($i = 0; $i < $total_sender_count; $i++) {
		            for ($j = $start; $j < $end; $j++) {
		            	if (@$total_target_numbers[$j]) {
		                    $pairing[$senders[$i]->phone][$senders[$i]->id][] = $total_target_numbers[$j];
		                    $paired++;
		                }
		            }
		            
		            if ($total_sender_count > 1) {
		                $start = $end;
		                $end   = $start + $targets_per_sender;
		            }
		            
		        }
		        $diff = $total_recipient_count - $paired;
		        if ($diff) {
		        	$start = $paired;
		            $end   = $start + 1;
		            for ($i = 0; $i < $diff; $i++) {
		                for ($j = $start; $j < $end; $j++) {
		                    if ($total_target_numbers[$j]) {
		                        $pairing[$senders[$i]->phone][$senders[$i]->id][] = $total_target_numbers[$j];
		                        $paired++;
		                    }
		                }

		                if ($total_sender_count > 1) {
		                    $start = $end;
		                    $end   = $start + 1;
		                }
		            }
		        }
				// Add Queue Details in to table.
				if($campaign_id){
					foreach($pairing as $key => $value){
						foreach ($value as $k => $val) {
							foreach ($val as $idx => $v) {
								$queueData = array();
								$queueData['sender_number'] = $key; 
								$queueData['sender_id'] = $k;
								$queueData['recipient_number'] = $v;
								$queueData['campaign_id'] = $campaign_id;
								$queueData['status'] = QUEUE_WAITING;
								$queueData['updated_at'] = CURRENT_DATE_TIME;

								$queue = $this->queues_model->addQueue($queueData);	
							}
							
						}
					}	
				}
				if($queue){
					$response = array('status' => 'success');
					$this->session->set_flashdata('success', 'Campaign added successfully.');
					echo json_encode($response);exit;
				}
			}else{
				//Return validation errors 
				$errors = validation_errors();
				$response = array('status' => 'error', 'result' => $errors);
        		echo json_encode($response);exit();
			}
		}
		/*
		Load all the recipiand Main Groups
		*/
		$data['recipientsMainGrps'] = $this->recipients_model->getAllParentGroups();

		$content = $this->load->view('Campaigns/add', $data, true);
		$this->render($content);
	}
	public function getSubgroups($parent_group_id='')
    {
        if($this->input->is_ajax_request()){
     		$parent_group_id = $this->input->post('id');   	
            $subgroups = $this->recipients_model->getAllChildrenGroups($parent_group_id);
            $html = "<option value=''>Select Sub Group</option>";
            foreach ($subgroups as $key => $value) {
              $html .= "<option value='".$value->id."'>".$value->res_group_name."</option>";
            }

            echo $html;
            exit;
        }
    }
    public function getRecipientPhoneNumbers()
    {
        if($this->input->is_ajax_request()){
     		$sub_group_id = $this->input->post('id');   	
            $recipientList = $this->recipients_model->getRecipentDataWithGroupValue($sub_group_id);
            
            $responseList = array();
            foreach ($recipientList as $key => $value) {
            	$responseList[$value->recipient_id] = $value->phone;
        	}

            echo json_encode($responseList);

            exit;
        }
    }
    public function delete($id=''){
    	if($id != ""){
			if($result = $this->campaigns_model->deleteCampaign($id)){
				$this->session->set_flashdata('success', 'Campaign deleted successfully.');
			}else{
				$this->session->set_flashdata('error', 'Problem in deleting campaign.');
			}

			redirect('Campaigns/index');
		}
    	
    }
    public function sendMessageWithProxy(){
    
    	$params = array('number' => '14388069480', 'nickname' => 'Shayan','debug'=>true);
        $this->load->library('whatsapp_lib',$params);
        $porxy_response = $this->whatsapp_lib->connect_with_proxy("23.106.26.222","29842","saudalq","kU81Mxa0");
        //$this->whatsapp_lib->Connect();
        $this->whatsapp_lib->LoginWithPassword('amq/RCbE8U6MY0adgPSzBEbGMM0=');
        $this->whatsapp_lib->sendMessage('919925030968', 'hello world Mrudul');

    }
    
    public function sendImageMessage(){
        $params = array('number' => '16473603595', 'nickname' => 'RL','debug'=>true);
        $this->load->library('whatsapp_lib',$params);
        $this->whatsapp_lib->Connect();
        $this->whatsapp_lib->LoginWithPassword('WuMVi38hvOPkpr1RJdF2V2c+zSk=');

        $to = "919925030968";
        $filepath = "../../uploads/Images/Desert.jpg"; 
        //$long = "77.0167";
        //$lat = "38.8833";
        $this->whatsapp_lib->sendMessageImage($to, $filepath, $storeURLmedia = false, $fsize = 0, $fhash = "", $caption = "");
        //$this->whatsapp_lib->sendMessageLocation($to, $long, $lat, $name = null, $url = null);
        $this->whatsapp_lib->pollMessage();
          
    }  
     
    function elfinder_init()
	{
		$opts = initialize_elfinder();
	  	$this->load->library('elfinder_lib', $opts);
	}


}

/* End of file Campaigns.php */
/* Location: ./application/controllers/Campaigns.php */