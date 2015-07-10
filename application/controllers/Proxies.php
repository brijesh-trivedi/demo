<?php

if ( !defined('BASEPATH') )
	exit('No direct script access allowed');

class Proxies extends My_Controller {

	/**
	 * Class Constructor method
	 */
	public function __construct(){
		parent::__construct();
		$this->load->model("proxy_model");
    }
	/**
	 * index method
	 */
	public function index() {
		
		$data['proxyData'] = $this->proxy_model->getProxyData();
		$data['counter'] = $this->proxy_model->getCustomData();

		$content = $this->load->view('Proxies/index', $data, true);
		$this->render($content);
	}

	/**
	 * add method
	 */
	public function add($id='') {

		if(isset($id) && $id != ""){
			
			$proxyData = $this->proxy_model->getProxyData($id);
			$data['proxyData'] = $proxyData;
			$data['formAction'] = 'Proxies/edit/'.$proxyData[0]->id;
						  
		}else{
			$data['formAction'] = 'Proxies/add';
		}

		//Check for POST Query.
		if($this->input->server('REQUEST_METHOD') == 'POST' && $this->input->post('submit')){

			$this->form_validation->set_rules('ip', 'Proxy', 'required|trim|valid_ip|is_unique[proxies.ip_address]');
			$this->form_validation->set_rules('port', 'Port', 'required|trim');
			$this->form_validation->set_rules('username', 'Username', 'required|trim');
			$this->form_validation->set_rules('password', 'Password', 'required|trim');

			if ($this->form_validation->run() == TRUE) {
				$newData = array();
				$newData['ip_address'] 	= $this->input->post('ip');
				$newData['port'] 		= $this->input->post('port');
				$newData['username'] 	= $this->input->post('username');
				$newData['password'] 	= $this->input->post('password');
				
				if($id != ""){
					$newData['updated_at'] 	= CURRENT_DATE_TIME;
					$newData['id'] 	= $id;
					if($result = $this->proxy_model->updateProxy($newData)){
						$this->session->set_flashdata('success', 'Proxy updated successfully.');
						redirect('Proxies/index');
					}else{
						$this->session->set_flashdata('error', 'Problem updating proxy with provided data.');
						redirect('Proxies/edit/'.$proxyData[0]->id);
					}
				}else{
					$proxy_id = $this->proxy_model->addProxy($newData);
					if($proxy_id){
						$this->session->set_flashdata('success', 'Proxy added successfully.');
						redirect('Proxies/index');
					}else{
						$this->session->set_flashdata('error', 'Problem adding proxy with provided data.');
						redirect('Proxies/add');
					}	
				}
			}
		}
		$content = $this->load->view('Proxies/add', $data, true);
		$this->render($content);
	}
	/**
	 * import method
	 */
	public function delete($id="") {
		if($id != ""){
			if($result = $this->proxy_model->deleteProxy($id)){
				$this->session->set_flashdata('success', 'Proxy deleted successfully.');
			}else{
				$this->session->set_flashdata('error', 'Problem in deleting proxy.');
			}

			redirect('Proxies/index');
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
    				redirect('Proxies/import');
    			}
    		}else{
    			$this->session->set_flashdata('error', 'Please select your file to upload.');
    			redirect('Proxies/import');
    		}
    		
    		$fp = fopen(CSV_UPLOAD_DIR.$uploadResult['upload_data']['file_name'],'r') or die("can't open file");
    		$skip = false;

    		if($this->input->post('skipheaders') != ""){
    			$skip = true;
    		}
    		$good_lines = 0;
    		$duplicates = 0;
			while($csv_line = fgetcsv($fp,1024)){
				if($skip){
					//preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $csv_line[0],$matches);
					//if(count($matches)>0){
						$skip = false;
						continue;
					//}
				}
				for ($i = 0, $j = count($csv_line); $i < $j; $i++){
					$insert_csv = array();
					$insert_csv['ip'] = $csv_line[0];
					$insert_csv['port'] = $csv_line[1];
					$insert_csv['username'] = $csv_line[2];
					$insert_csv['password'] = $csv_line[3];
		   		}	
		 
				$newData = array(
					'ip_address' 	=> $insert_csv['ip'] ,
					'port' 		=> $insert_csv['port'],
					'username' 	=> $insert_csv['username'],
					'password' 	=> $insert_csv['password'] ,
				);
				$where = array('ip_address' => $insert_csv['ip']);
				$existingProxy = $this->proxy_model->getProxyDataWithCriteria($where);
				if(!$existingProxy){
					$proxy_id = $this->proxy_model->addProxy($newData);	
					$good_lines = $good_lines+1;
				}else{
					$duplicates = $duplicates+1;
				}
				
			}
		    fclose($fp) or die("can't close file");
		    $this->session->set_flashdata('success', "CSV file has been processed successfully.<br> Good Lines : $good_lines <br> Duplicates : $duplicates");
    		redirect('Proxies/index');
    	}

		$content = $this->load->view('Proxies/import', null, true);
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
	/*
	*Test Mehtod
	*/
	public function testproxy($id=''){
		/*Get the requested proxy details*/
		$proxyData = $this->proxy_model->getProxyData($id);
		
		$postArray = array();
		$postArray['ip_address'] = $proxyData[0]->ip_address;
		$postArray['port'] = $proxyData[0]->port;
		$postArray['username'] = $proxyData[0]->username;
		$postArray['password'] = $proxyData[0]->password;

		$response = proxy_test($postArray);
		$res = json_decode($response,true);

		if($res['status'] == 1){
			/*Now update the proxy details in database*/
			
			$this->session->set_flashdata('success', "Proxy has been tested.");
			
		}else{
			$this->session->set_flashdata('error', "Bad proxy! Proxy not working.");
		}
		$data['status'] = $res['response_code'];
		$data['updated_at'] = CURRENT_DATE_TIME;
		$data['id'] = $id;

		$proxyData = $this->proxy_model->updateProxy($data);
		redirect('Proxies/index');
		

	}
	/*
	*	test individal proxies		
	*/
	public function test_with_shell(){
		$proxyData = $this->proxy_model->getProxyData();
		$goodProxyCount = 0;
		$badProxyCount = 0;
		$i=0;
		foreach ($proxyData as $key => $value) {
			
			if($value->ip_address != "" && $value->port != "" && $value->username != "" && $value->password != "")
			{

				$proxy_details['ip_address'] 	= $value->ip_address;
		   		$proxy_details['port']	= $value->port;	
		   		$proxy_details['username']	= $value->username;	
		   		$proxy_details['password']	= $value->password;	
		   		
		   		$response = proxy_test($proxy_details);
		 		$res = json_decode($response,true);

				if($res['status'] == 1){
					/*Now update the proxy details in database*/
					$data['status'] = $res['response_code'];
					$goodProxyCount++;
					
				}else{
					$data['status'] = $res['response_code'];
					$badProxyCount++;
					
				}
				$data['updated_at'] = CURRENT_DATE_TIME;
				$data['id'] = $value->id;

				$proxyData = $this->proxy_model->updateProxy($data);
			}
			/*$i++;
	        if($i % 100 == 0) {
	            sleep(3);
	        }*/
			
		}
	}
	/*
	*  function to test all available proxies
	*/
	public function test_all_proxies()
	{
		//$shell_command = base_url()."Proxies/test_with_shell  > /dev/null 2>/dev/null &";
		$shell_command = "php index.php Proxies test_with_shell";
		shell_exec($shell_command);
		redirect('Proxies/index');
	}
	/**
	 * blacklist method
	 */
	public function blacklist() {
		$content = $this->load->view('Proxies/blacklist', null, true);
		$this->render($content);
	}
	
	/**
	 * blacklist_add_form method
	 */
	public function blacklist_add_form() {
		$content = $this->load->view('Proxies/blacklist_add_form', null, true);
		$this->render($content);
	}

}

/* End of file Proxies.php */
/* Location: ./application/controllers/Proxies.php */