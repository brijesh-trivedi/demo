<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function pr($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}
function showMessage(){
	$CI =& get_instance();
	$message = "";
	if($CI->session->flashdata('error')){
  		$message = '<div class="alert alert-danger">
				      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				      <i class="fa fa-check sign"></i><strong>Error!</strong> ' . $CI->session->flashdata('error'). '
				     </div>';
 	}
 	if($CI->session->flashdata('success')){
  		$message = '<div class="alert alert-success">
				      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				      <i class="fa fa-check sign"></i><strong>Success!</strong> ' . $CI->session->flashdata('success'). '
				     </div>';
 	}
 	
 	return $message;
}
function validateErrors(){
	if(validation_errors()){
  		echo "<div class='ci_error_msg'>";
  		echo validation_errors();
  		echo "</div>";
 	}
}

function do_upload($con){
	 $CI =& get_instance();
	 $config['file_name'] = time() . '_' . $_FILES[$con['fileName']]["name"];
	 $config['upload_path'] = $con['path'];
	 $config['allowed_types'] = $con['allowType'];
	 //$config['max_size'] = $con['maxSize'];
	 //$config['max_width'] = '2000';
	 //$config['max_height'] = '2000';
	 $CI->load->library('upload', $config);
	 $CI->upload->initialize($config);
	 unset($config);
	 if (!$CI->upload->do_upload($con['fileName'])){
	  return array('error' => $CI->upload->display_errors(), 'status' => 0);
	 } else {
	  return array('status' => 1, 'upload_data' => $CI->upload->data());
	 }
}
function humanTiming($time)
{

    $time = time() - $time; // to get the time since that moment

    $tokens = array(31536000 => 'year',
                    2592000  => 'month',
                    604800   => 'week',
                    86400    => 'day',
                    3600     => 'hour',
                    60       => 'minute',
                    1        => 'second');

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) {
            continue;
        }
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
    }
}

function proxy_test($params, $optionalCheck_ssl = true, $optionalTimeout = null,  $optionalTime = 1){
	
	$proxyIP = $params['ip_address'];
	$proxyPort = $params['port'];
	$proxyUsername = $params['username'];
	$proxyPassword = $params['password'];

	$url = "http://google.com";

	$ch = curl_init();  // Initialise a cURL handle
	if($ch){
		if($optionalCheck_ssl){

			$proxy = $proxyUsername.':'.$proxyPassword.'@'.$proxyIP.':'.$proxyPort;

			// Setting proxy option for cURL
			if (isset($proxy)) {    // If the $proxy variable is set, then
			    curl_setopt($ch, CURLOPT_PROXY, $proxy);    // Set CURLOPT_PROXY with proxy in $proxy variable
			}
			
			// Set any other cURL options that are required
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_TIMEOUT, $optionalTimeout);
			curl_setopt($ch, CURLOPT_URL, $url);
			 
			$results = curl_exec($ch);  // Execute a cURL request
			$response = curl_getinfo( $ch );
			curl_close($ch);    // Closing the cURL handle
			//print_r($response);
			if($response['http_code'] == 200){
                                return json_encode(array('status'=> 1, 'response_code'=>'1'));
			}else{
				return json_encode(array('status'=> 0, 'response_code'=>'-2'));
			}

		}else{
			return json_encode(array('status'=> 1, 'response_code'=>'1'));
		}
	}else{
		if ($optionalTime < 4) {
			return proxy_test($proxyIP, $proxyPort, $proxyUsername, $proxyPassword, $optionalCheck_ssl, 2, $optionalTime + 1);

		}else{
			return json_encode(array('status'=> 0, 'response_code'=>'-2'));
		}
		return json_encode(array('status'=> 0, 'response_code'=>'-2'));
	}
}
function getInArray($array,$field){
 $arr = array();
 foreach($array as $val){
  $arr[] = $val->$field;
 }
 return $arr;
}
function initialize_elfinder($value=''){
	$CI =& get_instance();
	$CI->load->helper('path');
	$opts = array(
	    //'debug' => true, 
	    'roots' => array(
	      array( 
	        'driver' => 'LocalFileSystem', 
	        'path'   => './uploads/files/', 
	        'URL'    => site_url('uploads/files').'/'
	        // more elFinder options here
	      ) 
	    )
	);

	return $opts;
}
?>