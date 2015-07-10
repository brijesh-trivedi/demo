<?php

if ( !defined('BASEPATH') )
	exit('No direct script access allowed');

class Recipients extends My_Controller {
    
        public function __construct()
        {
            parent::__construct();
            $this->load->model("recipients_model");
        }
	/**
	 * index method
	 */
    	public function index() {
                $data['RecipientsData'] = $this->recipients_model->getRecipientsData();
		$content = $this->load->view('Recipients/index', $data, true);
		$this->render($content);
	}
	
	/**
	 * add method
	 */
	public function add($id = '') 
        {
            if(isset($id) && $id != "")
            {
                $recipientsData = $this->recipients_model->get($id);
                $recipientGroupData = $this->recipients_model->getSubGroupValue($id);
               
                $selectedChild = intval($recipientGroupData[0]->recipient_group_id);
                $Parent = $this->recipients_model->getParent($selectedChild);
                $selectedParent=intval($Parent[0]->parent_group_id);
                $subgroups = $this->recipients_model->getAllChildrenGroups($selectedParent);
                $data['subGroups'] = $subgroups;
                $data['selectedParent'] = $selectedParent;
                $data['selectedChild'] = $selectedChild;

                $data['recipientsData'] = $recipientsData;
                $data['formAction'] = 'Recipients/edit/'.$recipientsData[0]->recipient_id;
                $data['hidden'] = $recipientsData[0]->recipient_id;
                $data['label'] = _('Edit Recipient');
            }
            else
            {
                $data['formAction'] = 'Recipients/add';
                $data['hidden'] = '';
                $data['label']  = _('Add Recipient');
            }

            if ($this->input->server('REQUEST_METHOD') == 'POST')
            {
                $this->form_validation->set_rules('phone_number', 'Phone Number', 'required|trim');
                $this->form_validation->set_rules('status', 'status', 'required|trim');
             

                if ($this->form_validation->run() == TRUE)
                {
                    $phone = $this->input->post('phone_number');
                    $status = $this->input->post('status');
                    $data = array(
                        'phone' => $phone,
                        'status' => $status,
                        'updated_at' => CURRENT_DATE_TIME,
                    );
                   
                    if($id != ""){
                            $data['recipient_id']= intval($id);

                            if($result = $this->recipients_model->update($data)){
                                   $subGroup = $this->input->post('sub_group');
                                    $Subdata = array(
                                       'recipient_id' => intval($id),
                                       'recipient_group_id' => intval($subGroup),
                                       'updated_at' => CURRENT_DATE_TIME,
                                   );
                                if($result = $this->recipients_model->updateSubGroupValue($Subdata)){
                                        $this->session->set_flashdata('success', 'Recipient updated successfully.');
                                        redirect('Recipients/index');
                                }else{
                                        $this->session->set_flashdata('error', 'Problem updating recipient with provided data.');
                                        redirect('Recipients/edit/'.$data[0]->id);
                                }
                            }else{
                                    $this->session->set_flashdata('error', 'Problem updating recipient with provided data.');
                                    redirect('Recipients/edit/'.$data[0]->id);
                            }
                    }else{
                            $id = $this->recipients_model->add($data);
                            if($id){
                                    $subGroup = $this->input->post('sub_group');
                                     $Subdata = array(
                                        'recipient_id' => $id,
                                        'recipient_group_id' => intval($subGroup),
                                        'updated_at' => CURRENT_DATE_TIME,
                                    );
                                    $id = $this->recipients_model->addRecipientGroupValue($Subdata); 
                                    if($id){
                                            $this->session->set_flashdata('success', 'Recipient added successfully.');
                                            redirect('Recipients/index');
                                    }else{
                                            $this->session->set_flashdata('error', 'Problem adding recipient with provided data.');
                                            redirect('Recipients/add');
                                    }
                            }else{
                                    $this->session->set_flashdata('error', 'Problem adding recipient with provided data.');
                                    redirect('Recipients/add');
                            }	
                    }

                    redirect('Recipients/index');
                    return;
                }
            }
            $data['masterGroup'] = $this->recipients_model->getAllParentGroups();
            $content = $this->load->view('Recipients/add', $data, true);
            $this->render($content);
	}
	public function delete($id="") {
		if($id != ""){
			if($result = $this->recipients_model->delete($id)){
                            $this->session->set_flashdata('success', 'Recipient deleted successfully.');
			}else{
				$this->session->set_flashdata('error', 'Problem in deleting recipient.');
			}

			redirect('Recipients/index');
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
                                    redirect('Recipients/import');
                            }
                    }else{
                            $this->session->set_flashdata('error', 'Please select your file to upload.');
                            redirect('Recipients/import');
                    }

                    $fp = fopen(CSV_UPLOAD_DIR.$uploadResult['upload_data']['file_name'],'r') or die("can't open file");
                    $skip = false;

                    if($this->input->post('skipheaders') != ""){
                            $skip = true;
                    }
                    $subGroup = $this->input->post('sub_group');
                        while($csv_line = fgetcsv($fp)){
                                if($skip){
                                        //preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $csv_line[0],$matches);
                                        //if(count($matches)>0){
                                                $skip = false;
                                                continue;
                                        //}
                                }
                                if (!empty($csv_line))
                                {
                                    $insert_csv = array();
                                    $insert_csv['phone'] = $csv_line[0];
                                    $insert_csv['status'] = $csv_line[1];
                                }

                                $data = array(
                                       
                                        'phone' => $insert_csv['phone'],
                                        'status' 	=> $insert_csv['status'] ,
                                        'updated_at' 	=> CURRENT_DATE_TIME ,
                                );

                                $id = $this->recipients_model->add($data);
                                
                                if($id){
                                    $Subdata = array(
                                        'recipient_id' => $id,
                                        'recipient_group_id' => intval($subGroup),
                                        'updated_at' => CURRENT_DATE_TIME,
                                    );
                                    $id = $this->recipients_model->addRecipientGroupValue($Subdata); 
                                }
                            }
                         
                    fclose($fp) or die("can't close file");
                    $this->session->set_flashdata('success', "CSV file has been processed successfully.");
                    redirect('Recipients/index');
            }
            $data['masterGroup'] = $this->recipients_model->getAllParentGroups();
            $content = $this->load->view('Recipients/import', $data, true);
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
	 * groups method
	 */
	public function groups() {
        $groupData = $this->recipients_model->getAllChildrenGroups();
        $data['groupData'] = $groupData;
		$content = $this->load->view('Recipients/groups', $data, true);
		$this->render($content);
	}
    
	/**
	 * sub_groups method
	 */
	public function sub_groups($parent_group_id="") {
        
        $subGroups = $this->recipients_model->getAllChildrenGroups($parent_group_id);
        $data['subGroups'] = $subGroups;
        $data['parent_group_id'] = $parent_group_id;

		$content = $this->load->view('Recipients/sub_groups', $data, true);
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
                     $updateData['res_group_name'] = $group_name;
                     $updateData['id'] = $id;
                     $updateData['updated_at'] = CURRENT_DATE_TIME;
                     
                     if($this->recipients_model->updateRecipientGroup($updateData)){
                        $this->session->set_flashdata('success', 'Sender sub group updated successfully.');
                        redirect('Recipients/sub_groups/'.$parent_group_id);
                    }else{
                        $this->session->set_flashdata('error', 'Error updating sender group');
                        redirect('Recipients/sub_groups/'.$parent_group_id);
                    }
                    
                }else{
                    $insertData = array();
                    $insertData['res_group_name'] = $group_name;
                    $insertData['parent_group_id'] = $parent_group_id;

                    if($this->recipients_model->addRecipientGroup($insertData)){
                        $this->session->set_flashdata('success', 'Sub group added successfully.');
                        redirect('Recipients/sub_groups/'.$parent_group_id);
                    }else{
                        $this->session->set_flashdata('error', 'Error adding sub  group');
                        redirect('Recipients/sub_groups/'.$parent_group_id);
                    }
                }
            }

        }

    }
    public function add_recipient_group($id="") {
        
        if(isset($id) && $id != ""){
            
            $groupData = $this->recipients_model->getGroupData($id);
            $data['groupData'] = $groupData;
            $data['formAction'] = 'Recipients/edit_recipient_group/'.$groupData[0]->id;
            $data['selectMainGroup'] = $this->recipients_model->getAllParentGroups();
                          
        }else{
            $data['selectMainGroup'] = $this->recipients_model->getAllParentGroups();
            $data['formAction'] = 'Recipients/add_recipient_group';
        }
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            
            if($this->input->post('isParent') == 0){
                
                $this->form_validation->set_rules('recipientGroups[main_group]', 'Main Group', 'required|trim');
                //$this->form_validation->set_rules('recipientGroups[sub_group]', 'Sub Group', 'required|trim');
            }
            $this->form_validation->set_rules('res_group_name', 'Group Name', 'required|trim');

            if ($this->form_validation->run() == TRUE){
                
                $res_group_name = $this->input->post('res_group_name');
                if($id != ''){
                    $updateData = array();
                    $updateData['id'] = $id;
                    $updateData['res_group_name'] = $res_group_name;

                    if($this->input->post('isParent') == 0){
                        $parent_group_id = $this->input->post('recipientGroups[main_group]');
                        $updateData['parent_group_id'] = $parent_group_id;
                    }else{
                        $updateData['parent_group_id'] = '0';
                    }

                    if($this->recipients_model->updateRecipientGroup($updateData)){
                        $this->session->set_flashdata('success', 'Sender group updated successfully.');
                        redirect('Recipients/groups');
                    }else{
                        $this->session->set_flashdata('error', 'Error updating sender group');
                        redirect('Recipients/edit_recipient_group/'.$id);
                    }


                }else{
                    $insertData = array();
                    $insertData['res_group_name'] = $res_group_name;
                    
                    if($this->input->post('isParent') == 0){
                        $parent_group_id = $this->input->post('recipientGroups[main_group]');
                        $insertData['parent_group_id'] = $parent_group_id;
                    }else{
                        $insertData['parent_group_id'] = '0';
                    }

                    if($this->recipients_model->addRecipientGroup($insertData)){
                        $this->session->set_flashdata('success', 'Sender group added successfully.');
                        redirect('Recipients/groups');
                    }else{
                        $this->session->set_flashdata('error', 'Error adding sender group');
                        redirect('Recipients/add_recipient_group');
                    }
                }

            }
           
        }
        $content = $this->load->view('Recipients/add_recipient_group', $data, true);
        $this->render($content);
    }

    public function deletegroup($id=''){
        if($id != ""){
            if($result = $this->recipients_model->deleteGroup($id)){
                $this->session->set_flashdata('success', 'Group deleted successfully.');
            }else{
                $this->session->set_flashdata('error', 'Problem in deleting Group.');
            }

            redirect('Recipients/groups');
        }
    }
    public function getSubGroupsValue()
    {
        $parent_group_id = $this->input->post('id');
        if($this->input->is_ajax_request()){
            $subgroups = $this->recipients_model->getAllChildrenGroups($parent_group_id);
            $html = "<option value=''>Select Sub Group</option>";
            foreach ($subgroups as $key => $value) {
              $html .= "<option value='".$value->id."'>".$value->res_group_name."</option>";
            }

            echo $html;
            exit;
        }
    }

}

/* End of file Recipients.php */
/* Location: ./application/controllers/Recipients.php */