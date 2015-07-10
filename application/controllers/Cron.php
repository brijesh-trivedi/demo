<?php
if ( !defined('BASEPATH') )
	exit('No direct script access allowed');
class Cron extends My_Controller 
{
    protected $shell_commad_prefix = "php index.php ";
    protected $shell_command_postfix = " > /dev/null 2>/dev/null &";
    protected $sender_id = 0;
    public function __construct() {
        parent::__construct();
        $this->load->model("corn_model");
    }
    
    public function sender_block_checker()
    {
        $shell_command = $this->shell_commad_prefix."senders test_all_senders";
	shell_exec($shell_command);
	redirect('Senders/index');
    }
    public function senderMessage()
    {
        $shell_command = $this->shell_commad_prefix."senders test_all_senders";
	    shell_exec($shell_command);
	    redirect('Senders/index');
    }

    public function senderPasswordChange()
    {
        $params = array('number' => '15812220862', 'nickname' => '','debug'=>false,'identityFile'=>true);
        $this->load->library('whatsapp_lib',$params);
        $this->whatsapp_lib->connect_with_proxy("23.106.26.222","29842","saudalq","kU81Mxa0");
        //$this->whatsapp_lib->Login();

        $e = new MyEvents($this->whatsapp_lib);
        $this->whatsapp_lib->eventManager()->bind("onLoginFailed", array($this,"onLoginFailed"));
        $this->whatsapp_lib->eventManager()->bind("onLoginSuccess", array($this,"onLoginSuccess"));
        $this->whatsapp_lib->connect();
        $this->whatsapp_lib->LoginWithPassword('0xtSPpNmslrKZJ4N/yU1afP708I=');

        //$response = $this->whatsapp_lib->checkCredentials();
        //var_dump($response);
        //$params = array('number' => '923004412255', 'nickname' => '','debug'=>true,'identityFile'=>true);
        //$this->load->library('whatsapp_lib',$params);
        //$this->whatsapp_lib->codeRequest('sms');

        //$result = $this->whatsapp_lib->codeRegister(trim('804477'));
        //var_dump($result);


        //$this->whatsapp_lib->codeRequest('sms');
        //$this->whatsapp_lib->checkCredentials();

        /*
        $this->whatsapp_lib->Connect();
        $this->whatsapp_lib->LoginWithPassword('amq/RCbE8U6MY0adgPSzBEbGMM0=');
        $this->whatsapp_lib->eventManager()->bind("onCredentialsBad", array($this,"onCredentialsBad"));
        $this->whatsapp_lib->eventManager()->bind("onCredentialsGood", array($this,"onCredentialsGood"));
        $this->whatsapp_lib->checkCredentials();
        */
        /*
        $username = "your number";
        $identity = strtolower(urlencode(sha1($username, true)));
        $w = new WhatsProt($username, $identity, "nick name", true);
        $result = $w->codeRegister("sms code");
        $password = $result->pw;
        echo "Password is $password";
        */
    }

    public function onCredentialsBad($mynumber, $status, $reason)
    {
        echo $mynumber.":".$status.":".$reason;
        if ($reason == 'blocked') {
            echo "\n\nYour number is blocked \n";
            exit();
           
        }
        if ($reason == 'incorrect') {
            echo "\n\nWrong identity. \n"; exit();
            
        }

    }
    public function onCredentialsGood($mynumber, $login, $password, $type, $expiration, $kind, $price, $cost, $currency, $price_expiration)
    {
        echo "\n\nYour number $mynumber with the following password $password is not blocked \n"; exit();
    }
    public function onLoginFailed($mynumber,$data)
    {
       echo "\n\nFailed. \n"; 
    }

    public function onLoginSuccess($mynumber, $kind, $status, $creation, $expiration)
    {
       echo "\n\nLogin. \n"; 
    }
    public function sendMessage(){
        //14388069480,16473610267,14388069480,
        
        $params = array('number' => '15812220862', 'nickname' => '','debug'=>true);
        $this->load->library('whatsapp_lib',$params);
        //$this->whatsapp_lib->Connect();
        //$this->whatsapp_lib->connect_with_proxy();
        $this->whatsapp_lib->connect_with_proxy("136.0.117.240","29842","saudalq","kU81Mxa0");
        $this->whatsapp_lib->LoginWithPassword('0xtSPpNmslrKZJ4N/yU1afP708I=');
        $this->whatsapp_lib->sendMessage('923004412255', 'hello 3rd in database');
       
    }
    
    public function sendImage(){
        $params = array('number' => '14388069480', 'nickname' => '','debug'=>true);
        $this->load->library('whatsapp_lib',$params);
        $this->whatsapp_lib->connect_with_proxy("136.0.117.240","29842","saudalq","kU81Mxa0");
        $this->whatsapp_lib->LoginWithPassword('amq/RCbE8U6MY0adgPSzBEbGMM0=');
        
        $caption = "Look at this awesome image!";
        $target = "34123456789";
        $pathToVideo = "http://dev.skytop.co.uk/images/agent_website.jpg"; // This could be url or path to image.
        $this->whatsapp_lib->sendMessageImage('16473610267', $pathToVideo, null, false, 0, null, $caption);              
    }
        
    public function sendVideo(){
        $params = array('number' => '14388069480', 'nickname' => '','debug'=>true);
        $this->load->library('whatsapp_lib',$params);
        $this->whatsapp_lib->connect_with_proxy("136.0.117.240","29842","saudalq","kU81Mxa0");
        $this->whatsapp_lib->LoginWithPassword('amq/RCbE8U6MY0adgPSzBEbGMM0=');
        
        $caption = "Look at this awesome Video!";
        $target = "34123456789";          
        $pathToVideo = "http://download.wavetlan.com/SVV/Media/HTTP/H264/Talkinghead_Media/H264_test1_Talkinghead_mp4_480x360.mp4";        
        $this->whatsapp_lib->sendMessageVideo('16473610267', $pathToVideo, null, false, 0, null, $caption);                
    }       
    public function sendAudio(){
        $params = array('number' => '14388069480', 'nickname' => '','debug'=>true);
        $this->load->library('whatsapp_lib',$params);
        $this->whatsapp_lib->connect_with_proxy("136.0.117.240","29842","saudalq","kU81Mxa0");
        $this->whatsapp_lib->LoginWithPassword('amq/RCbE8U6MY0adgPSzBEbGMM0=');
        
        $caption = "Look at this awesome Video!";
        $target = "34123456789";          
        $pathToAudio = "http://localhost/x.mp3";        
        $this->whatsapp_lib->sendMessageAudio('16473610267', $pathToAudio, null, false, 0, null);                
    }      
    public function receiveMessage()
    {
        //insert in inbox according to receiver reply 
        $records = $this->corn_model->get();
        foreach ($records as $key=>$value){
            $this->sender_id=$value->sender_id;
            $params = array('number' => $value->sender_number, 'nickname' => '','debug'=>true);
            $this->load->library('whatsapp_lib',$params);       
            $this->whatsapp_lib->connect_with_proxy("136.0.117.240","29842","saudalq","kU81Mxa0");
            $this->whatsapp_lib->LoginWithPassword($value->password);
            $this->whatsapp_lib->eventManager()->bind("onGetMessage", array($this,"onGetMessage"));
            while($this->whatsapp_lib->pollMessage()){
                 //$this->whatsapp_lib->eventManager()->bind("onGetMessage", array($this,"onGetMessage"));
            }
        }
    }      
    public function sendLocationMessage(){
        $params = array('number' => '16473603595', 'nickname' => 'RL','debug'=>true);
        $this->load->library('whatsapp_lib',$params);
        $this->whatsapp_lib->Connect();
        $this->whatsapp_lib->LoginWithPassword('WuMVi38hvOPkpr1RJdF2V2c+zSk=');

        $to = "16473610267";
        $long = "77.0167";
        $lat = "38.8833";
        $this->whatsapp_lib->sendMessageLocation($to, $long, $lat, $name = null, $url = null);
        $this->whatsapp_lib->pollMessage();
    }  
    public function sendMessageWithProxy(){
    
        $params = array('number' => '14388069480', 'nickname' => 'Shayan','debug'=>true);
        $this->load->library('whatsapp_lib',$params);
        $porxy_response = $this->whatsapp_lib->connect_with_proxy("23.106.26.222","29842","saudalq","kU81Mxa0");
        //$this->whatsapp_lib->Connect();
        $this->whatsapp_lib->LoginWithPassword('amq/RCbE8U6MY0adgPSzBEbGMM0=');
        $this->whatsapp_lib->sendMessage('919925030968', 'hello world Mrudul');
    }
    
    public function onGetMessage($mynumber, $from, $id, $type, $time, $name, $body)
    {
        $data = array(
                    'from_number' => $from,
                    'sender_id' => $this->sender_id,
                    'type' => $type,
                    'content' => $body,
                    'received_at' => CURRENT_DATE_TIME
                );
        $this->corn_model->add($data);
    }


    
}
