<?php

if ( !defined('BASEPATH') )
	exit('No direct script access allowed');

class Senders extends MY_UserController
{
    protected $senderStatus;
    public function __construct()
    {
        parent::__construct();
        $this->load->model("sender_model");
    }

	/**
	 * index method
	 */
	public function index() {
                $data['senderData'] = $this->sender_model->get();
                $content = $this->load->view('Senders/index', $data, true);
		$this->render($content);
	}
	
	/**
	 * add method
	 */
    public function add($id = '')
    {
        if(isset($id) && $id != "")
        {
            $senderData = $this->sender_model->get($id);
            $senderGroupData = $this->sender_model->getSubGroupValue($id);
            $selectedChild = intval($senderGroupData[0]->sender_group_id);
            $Parent = $this->sender_model->getParent($selectedChild);
            $selectedParent=intval($Parent[0]->parent_group_id);
            $subgroups = $this->sender_model->getAllChildrenGroups($selectedParent);
            
            $data['senderData'] = $senderData;
            $data['subGroups'] = $subgroups;
            $data['selectedParent'] = $selectedParent;
            $data['selectedChild'] = $selectedChild;
            $data['formAction'] = 'Senders/edit/'.$senderData[0]->id;
            $data['hidden'] = $senderData[0]->id;
            $data['label'] = _('Edit Sender');
        }
        else
        {
            $data['formAction'] = 'Senders/add';
            $data['hidden'] = '';
            $data['label']  = _('Add Sender');
        }

        if ($this->input->server('REQUEST_METHOD') == 'POST')
        {
            $this->form_validation->set_rules('phone_number', 'Phone Number', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');
            $this->form_validation->set_rules('identity_number', 'Password', 'trim');
            $this->form_validation->set_rules('wart_password', 'Password', 'trim');
            $this->form_validation->set_rules('nickname', 'Nickname', 'required|trim');

            if ($this->form_validation->run() == TRUE)
            {
                $phone = $this->input->post('phone_number');

                $password = $this->input->post('password');
                $identity_number = $this->input->post('identity_number');

                $wart_password = $this->input->post('wart_password');
                $nickname = $this->input->post('nickname');
                $proxy = $this->input->post('proxy');
                $whatsapp_device = WHATSAPP_DEVICE;
                $whatsapp_version = WHATSAPP_VERSION;
                $whatsapp_user_agent = WHATSAPP_USER_AGENT;

                $data = array(
                    'proxy_id' => $proxy,
                    'phone' => $phone,
                    'password' => $password,
                    'identity_number' => $identity_number,
                    'wart_password' => $wart_password,
                    'nickname' => $nickname,
                    'updated_at' => CURRENT_DATE_TIME,
                    'whatsapp_device' => $whatsapp_device,
                    'whatsapp_ver' => $whatsapp_version,
                    'whatsapp_user_agent' => $whatsapp_user_agent,
                    'status'=>ACTIVE
                );
                //$id = $this->sender_model->add($data);

                if($id != ""){
                        $data['id']= intval($id);

                        if($result = $this->sender_model->update($data)){
                                 $subGroup = $this->input->post('sub_group');
                                 $Subdata = array(
                                    'sender_id' => intval($id),
                                    'sender_group_id' => intval($subGroup),
                                    'update_at' => CURRENT_DATE_TIME,
                                );
                                if($result = $this->sender_model->updateSubGroupValue($Subdata)){
                                        $this->session->set_flashdata('success', 'Sender updated successfully.');
                                        redirect('Senders/index');
                                }else{
                                        $this->session->set_flashdata('error', 'Problem updating sender with provided data.');
                                        redirect('Senders/edit/'.$data[0]->id);
                                }
                              
                        }else{
                                $this->session->set_flashdata('error', 'Problem updating sender with provided data.');
                                redirect('Senders/edit/'.$data[0]->id);
                        }
                }else{
                        $id = $this->sender_model->add($data);
                        if($id){
                            
                                 $subGroup = $this->input->post('sub_group');
                                 $Subdata = array(
                                    'sender_id' => $id,
                                    'sender_group_id' => intval($subGroup),
                                    'update_at' => CURRENT_DATE_TIME,
                                );
                                $id = $this->sender_model->addSenderGroupValue($Subdata); 
                                 if($id){
                                        $this->session->set_flashdata('success', 'Sender added successfully.');
                                        redirect('Senders/index');
                                }else{
                                        $this->session->set_flashdata('error', 'Problem adding sender with provided data.');
                                        redirect('Senders/add');
                                }
                                
                        }else{
                                $this->session->set_flashdata('error', 'Problem adding sender with provided data.');
                                redirect('Senders/add');
                        }	
                }

                redirect('Senders/index');
                return;
            }
        }
            $data['masterGroup'] = $this->sender_model->getAllParentGroups();
            $data['proxies']=$this->sender_model->getProxies();
            $content = $this->load->view('Senders/add', $data, true);
            $this->render($content);
	}
	public function delete($id="") {
		if($id != ""){
			if($result = $this->sender_model->delete($id)){
				$this->session->set_flashdata('success', 'Sender deleted successfully.');
			}else{
				$this->session->set_flashdata('error', 'Problem in deleting sender.');
			}

			redirect('Senders/index');
		}
	}
	/**
	 * import method
	 */
        
        public function import() {

            if($this->input->server('REQUEST_METHOD') == 'POST'){
               
                    if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != '' ){
                            $uploadResult = $this->uploadCSV();
                            if(!$uploadResult['status']){
                                    $this->session->set_flashdata('error', 'Problem in uploading your file.');
                                    redirect('Senders/import');
                            }
                    }else{
                            $this->session->set_flashdata('error', 'Please select your file to upload.');
                            redirect('Senders/import');
                    }

                    $fp = fopen(CSV_UPLOAD_DIR.$uploadResult['upload_data']['file_name'],'r') or die("can't open file");
                    $skip = false;

                    if($this->input->post('skipheaders') != ""){
                            $skip = true;
                    }
                    $subGroup = $this->input->post('sub_group');
                    
                    
                        while($csv_line = fgetcsv($fp)){
                                $result=$this->sender_model->getLeastCountProxies();
                                $proxy_id=$result[0]->id;
                            
                                if($skip)
                                {
                                    $skip = false;
                                    continue;
                                }
                                if (!empty($csv_line))
                                {
                                    $insert_csv = array();
                                    $insert_csv['proxy_id'] = $proxy_id;
                                    $insert_csv['phone'] = $csv_line[0];
                                    $insert_csv['nickname'] = $csv_line[1];
                                    $insert_csv['password'] = $csv_line[2];
                                    $insert_csv['identity_number'] = $csv_line[3];
                                    $insert_csv['wart_password'] = $csv_line[4];
                                    $insert_csv['status'] = $csv_line[5 ];
                                    $insert_csv['updated_at'] = CURRENT_DATE_TIME;
                                    $insert_csv['whatsapp_device'] = WHATSAPP_DEVICE;
                                    $insert_csv['whatsapp_ver'] = WHATSAPP_VERSION;
                                    $insert_csv['whatsapp_user_agent'] = WHATSAPP_USER_AGENT;
                                }
                                /*
                                $data = array(
                                        'proxy_id' 	=> $insert_csv['proxy_id'] ,
                                        'phone' 		=> $insert_csv['phone'],
                                        'wart_password' 	=> $insert_csv['wart_password'],
                                        'nickname' 	=> $insert_csv['nickname'],
                                        'status' 	=> $insert_csv['status'] ,
                                        'updated_at' 	=> $insert_csv['updated_at'] ,
                                        'whatsapp_device' 	=> $insert_csv['whatsapp_device'] ,
                                        'whatsapp_ver' 		=> $insert_csv['whatsapp_ver'],
                                        'whatsapp_user_agent' 	=> $insert_csv['whatsapp_user_agent'],

                                );
                                */

                                $id = $this->sender_model->add($insert_csv);
                                if($id){
                                    $Subdata = array(
                                        'sender_id' => $id,
                                        'sender_group_id' => intval($subGroup),
                                        'update_at' => CURRENT_DATE_TIME,
                                    );
                                 $subGroupId = $this->sender_model->addSenderGroupValue($Subdata); 
                                }         
                            }
                        fclose($fp) or die("can't close file");
                        $this->session->set_flashdata('success', "CSV file has been processed successfully.");
                    redirect('Senders/index');
            }
            $data['masterGroup'] = $this->sender_model->getAllParentGroups();
            $content = $this->load->view('Senders/import', $data, true);
            $this->render($content);
	}
	public function uploadCSV( $fileName = 'file' ){
		////////////Image Upload start////////
		$csvUploadPath = CSV_UPLOAD_DIR;
                 
		$csvConfig['fileName'] = $fileName;
		$csvConfig['path'] = $csvUploadPath;		
		$csvConfig['allowType'] = 'csv';
		$uploadResult = do_upload($csvConfig);
                if($uploadResult){
			return $uploadResult;				
		}else{
			return false;
		}	
	
		////////////Image Upload End//////////
	} 
     
	/**
	 * nickname method
	 */
	public function nickname() {
            if ($this->input->server('REQUEST_METHOD') == 'POST'){
                $subGroup = $this->input->post('sub_group');
                $result= -1;
                $senderIds = $this->sender_model->getSenderId($subGroup);
                foreach($senderIds as $ids){

                    $nickname = $this->input->post('nickname');
                    $data = array(
                        'nickname' => $nickname,
                    );
                    if( $ids->sender_id != ""){
                            $data['id']= intval($ids->sender_id);
                            $result = $this->sender_model->update($data);
                    }
                }
                 if($result){
                        $this->session->set_flashdata('success', 'Nickname updated successfully.');
                        redirect('Senders/index');
                }
                
            }
                $data['masterGroup'] = $this->sender_model->getAllParentGroups();
		$content = $this->load->view('Senders/nickname', $data, true);
		$this->render($content);
	}
	
	/**
	 * groups method
	 */
	public function groups() {
        //$groupData = $this->sender_model->getGroupData();
        $groupData = $this->sender_model->getAllChildrenGroups('0');
        $data['groupData'] = $groupData;
        $content = $this->load->view('Senders/groups', $data, true);
		$this->render($content);
	}
	
	/**
	 * sub_groups method
	 */
	public function sub_groups($parent_group_id="") {
        $subGroups = $this->sender_model->getAllChildrenGroups($parent_group_id);
        //pr($subGroups);die;
        $data['subGroups'] = $subGroups;
        $data['parent_group_id'] = $parent_group_id;
        
        $content = $this->load->view('Senders/sub_groups', $data, true);
		$this->render($content);
	}
	public function add_sub_groups($id=""){
      
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            
            $this->form_validation->set_rules('sub_group_name', 'Sub Group Name', 'required|trim');
            if($this->form_validation->run() == TRUE){
                $group_name = $this->input->post('sub_group_name');
                $parent_group_id = $this->input->post('parent_group_id');

                if(isset($id) && $id != ""){
                     $updateData = array();
                     $updateData['group_name'] = $group_name;
                     $updateData['id'] = $id;
                     $updateData['updated_at'] = CURRENT_DATE_TIME;
                     
                     if($this->sender_model->updateSenderGroup($updateData)){
                        $this->session->set_flashdata('success', 'Sender sub group updated successfully.');
                        redirect('Senders/sub_groups/'.$parent_group_id);
                    }else{
                        $this->session->set_flashdata('error', 'Error updating sender group');
                        redirect('Senders/sub_groups/'.$parent_group_id);
                    }
                    
                }else{
                    $insertData = array();
                    $insertData['group_name'] = $group_name;
                    $insertData['parent_group_id'] = $parent_group_id;

                    if($this->sender_model->addSenderGroup($insertData)){
                        $this->session->set_flashdata('success', 'Sub group added successfully.');
                        redirect('Senders/sub_groups/'.$parent_group_id);
                    }else{
                        $this->session->set_flashdata('error', 'Error adding sub  group');
                        redirect('Senders/sub_groups/'.$parent_group_id);
                    }
                }
            }

        }

    }
	/**
	 * add_sender_group method
	 */
	public function add_sender_group($id="") {
        
        if(isset($id) && $id != ""){
            
            $groupData = $this->sender_model->getGroupData($id);
            $data['groupData'] = $groupData;
            $data['formAction'] = 'Senders/edit_sender_group/'.$groupData[0]->id;
            $data['selectMainGroup'] = $this->sender_model->getAllParentGroups();
                          
        }else{
            $data['selectMainGroup'] = $this->sender_model->getAllParentGroups();
            $data['formAction'] = 'Senders/add_sender_group';
        }
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            
            if($this->input->post('isParent') == 0){
                
                $this->form_validation->set_rules('senderGroups[main_group]', 'Main Group', 'required|trim');
                //$this->form_validation->set_rules('senderGroups[sub_group]', 'Sub Group', 'required|trim');
            }
            $this->form_validation->set_rules('group_name', 'Group Name', 'required|trim');

            if ($this->form_validation->run() == TRUE){
                
                $group_name = $this->input->post('group_name');
                if($id != ''){
                    $updateData = array();
                    $updateData['id'] = $id;
                    $updateData['group_name'] = $group_name;
                    $updateData['updated_at'] = CURRENT_DATE_TIME;

                    if($this->input->post('isParent') == 0){
                        $parent_group_id = $this->input->post('senderGroups[main_group]');
                        $updateData['parent_group_id'] = $parent_group_id;
                    }else{
                        $updateData['parent_group_id'] = '0';
                    }

                    if($this->sender_model->updateSenderGroup($updateData)){
                        $this->session->set_flashdata('success', 'Sender group updated successfully.');
                        redirect('Senders/groups');
                    }else{
                        $this->session->set_flashdata('error', 'Error updating sender group');
                        redirect('Senders/edit_sender_group/'.$id);
                    }


                }else{
                    $insertData = array();
                    $insertData['group_name'] = $group_name;
                    
                    if($this->input->post('isParent') == 0){
                        $parent_group_id = $this->input->post('senderGroups[main_group]');
                        $insertData['parent_group_id'] = $parent_group_id;
                    }else{
                        $insertData['parent_group_id'] = '0';
                    }

                    if($this->sender_model->addSenderGroup($insertData)){
                        $this->session->set_flashdata('success', 'Sender group added successfully.');
                        redirect('Senders/groups');
                    }else{
                        $this->session->set_flashdata('error', 'Error adding sender group');
                        redirect('Senders/add_sender_group');
                    }
                }

            }
           
        }
		$content = $this->load->view('Senders/add_sender_group', $data, true);
		$this->render($content);
	}
    public function getSubgroups($parent_group_id='')
    {
        if($this->input->is_ajax_request()){
            $subgroups = $this->sender_model->getAllChildrenGroups($parent_group_id);
            $html = "<option value=''>Select Sub Group</option>";
            foreach ($subgroups as $key => $value) {
              $html .= "<option value='".$value->id."'>".$value->group_name."</option>";
            }

            echo $html;
            exit;
        }
    }
    public function deletegroup($id=''){
        if($id != ""){
            if($result = $this->sender_model->deleteGroup($id)){
                $this->session->set_flashdata('success', 'Group deleted successfully.');
            }else{
                $this->session->set_flashdata('error', 'Problem in deleting Group.');
            }

            redirect('Senders/groups');
        }
    }
    /**
     * Function for getting sub group and return to Sender add page
     */
    public function getSubGroupsValue()
    {
        $parent_group_id = $this->input->post('id');
        if($this->input->is_ajax_request()){
            $subgroups = $this->sender_model->getAllChildrenGroups($parent_group_id);
            $html = "<option value=''>Select Sub Group</option>";
            foreach ($subgroups as $key => $value) {
              $html .= "<option value='".$value->id."'>".$value->group_name."</option>";
            }

            echo $html;
            exit;
        }
    }
    
    /**
     * Get block and unblock sender
     */
    public function test_all_senders()
    {

        $allSenders=$this->sender_model->getSenderProxy();

        $debug = true;
        //add join query which will fetch all records of sender and proxy
        foreach($allSenders as $key=>$value)
        {
            echo "calling";
            $id = $value->id;
            $phone=$value->phone;
            $password=$value->password;
            $nickname=$value->nickname;
            $params = array('number' => $phone, 'nickname' => '','debug'=>true);
            $this->load->library('whatsapp_lib',$params);
            $proxy_response = $this->whatsapp_lib->connect_with_proxy($value->ip_address,$value->port,$value->username,$value->pPassword);
            $this->whatsapp_lib->eventManager()->bind("onLoginFailed", array($this,"onLoginFailed"));
            $this->whatsapp_lib->eventManager()->bind("onLoginSuccess", array($this,"onLoginSuccess"));
            $this->whatsapp_lib->loginWithPassword($password);

            if($this->senderStatus=='InActive'){
                $this->senderStatus = INACTIVE;
            }
            elseif($this->senderStatus == 'Active'){
                $this->senderStatus = ACTIVE;
            }
            $data = array(
                   'updated_at' => CURRENT_DATE_TIME,
                   'status'=>$this->senderStatus
            );
            $data['id']= $id;
            $this->sender_model->update($data);
            //sleep(10);
        }
    }
   
    public function onLoginFailed($mynumber,$data)
    {
        echo "login failed".$mynumber."<br>";
       $this->senderStatus='InActive';
    }

    public function onLoginSuccess($mynumber, $kind, $status, $creation, $expiration)
    {
        echo "login failed".$mynumber."<br>";
       $this->senderStatus='Active';
    }
    //update Status
    
}

/* End of file Senders.php */
/* Location: ./application/controllers/Senders.php */
