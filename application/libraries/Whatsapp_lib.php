<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include APPPATH.'third_party/whatsapp/src/whatsprot.class.php';
include APPPATH.'third_party/whatsapp/src/events/MyEvents.php';
include APPPATH.'third_party/whatsapp/src/vCard.php';

class Whatsapp_lib extends WhatsProt{

    public function __construct($params)
    {
        $debug = isset($params['debug'])?$params['debug']:false;
        $identityFile = isset($params['identityFile'])?$params['identityFile']:false;
        parent::__construct($params['number'], $params['nickname'], $debug, $identityFile);
        // We will load the configuration for braintree
        //$CI = &get_instance();
        //$CI->config->load('whatsapp', TRUE);
        //$whatsapp = $CI->config->item('whatsapp');
        // Let us load the configurations for the braintree library
        //Whatsapp_Configuration::environment($whatsapp['whatsapp_environment']);
        //Whatsapp_Configuration::merchantId($whatsapp['whatsapp_merchant_id']);
        //Whatsapp_Configuration::publicKey($whatsapp['whatsapp_public_key']);
        //Whatsapp_Configuration::privateKey($whatsapp['whatsapp_private_key']);
    }

    // This function simply creates a client token for the javascript sdk
    function create_client_token(){
        $clientToken = Whatsapp_ClientToken::generate();
        return $clientToken;
    }

    public function connect_with_proxy($proxy_ip = null, $proxy_port = null, $proxy_username = null, $proxy_password = null){
        
        if ($this->isConnected()) {
            return true;
        }
        
        if ($proxy_ip != "" && $proxy_port != "") {
            $proxy_ip = preg_replace(array('/[^0-9.]/s'), array(''), $proxy_ip);
            $proxy_port = preg_replace(array('/[^0-9]/s'), array(''), $proxy_port);
            //$proxy_test = $this->test_proxy($proxy_ip, $proxy_port, $proxy_username, $proxy_password);
            $proxy_details['ip_address']    = $proxy_ip;
            $proxy_details['port']  = $proxy_port; 
            $proxy_details['username']  = $proxy_username; 
            $proxy_details['password']  = $proxy_password; 
            
            $proxy_test = proxy_test($proxy_details);
            $proxy_test = (array)json_decode($proxy_test);
            if ($proxy_test['status']) {
                $socket = fsockopen($proxy_ip, $proxy_port);
                $data = "CONNECT e" . rand(1, 16) . ".whatsapp.net:" . Constants::PORT . " HTTP/1.1\r\n";
                fputs($socket, $data);
                if($proxy_username && $proxy_password)
                fputs($socket, "Proxy-Authorization: Basic ". base64_encode ($proxy_username.":".$proxy_password)."\r\n\r\n");
                $socket_result = trim(fread($socket, 8192));
                if (strpos($socket_result, "200 ") === false) {
                    //throw new Exception('There was a problem trying to connect whatsapp server.');
                    return array('status'=> 0, 'response'=>'There was a problem trying to connect whatsapp server.');
                } else {
                    //var_dump("Proxy OK! -> {$socket_result}");
                }
            }
            else
            {
                return array('status'=> 0, 'response'=>'There was a problem connectin with Proxy information.');
            }
            
        }
        else
        {
             return array('status'=> 0, 'response'=>'No proxy provided.');
        }
        
        
        if ($socket !== false) {
            stream_set_timeout($socket, Constants::TIMEOUT_SEC, Constants::TIMEOUT_USEC);
            $this->socket = $socket;
            $this->eventManager()->fire("onConnect",
                array(
                    $this->phoneNumber,
                    $this->socket
                )
            );
            return array('status'=> 1, 'response'=>$proxy_test['response_code']);
        }
        else
        {
            $this->eventManager()->fire("onConnectError",
                array(
                    $this->phoneNumber,
                    $this->socket
                )
            );
            return array('status'=> 0, 'response'=>$proxy_test['response_code']);
        }
    }
    
    /*Override the API function to replace the socket_write with fwrite*/
    protected function sendData($data)
    {
        if ($this->socket != null) {
            fwrite($this->socket, $data, strlen($data));
        }
    }

    /* Override API function */
    public function pollMessage($autoReceipt = true, $type = "read")
    {
        if (!$this->isConnected()) {
            throw new ConnectionException('Connection Closed!');
        }

        $r = array($this->socket);
        $w = array();
        $e = array();

        //if (socket_select($r, $w, $e, Constants::TIMEOUT_SEC, Constants::TIMEOUT_USEC)) {
            // Something to read
            if ($stanza = $this->readStanza()) {
                $this->processInboundData($stanza, $autoReceipt, $type);
                return true;
            }
        //}

        return false;
    }
    /* Override API function */
    public function readStanza()
    {
        $buff = '';
        if ($this->socket != null) {
            $header = @fread($this->socket, 3);//read stanza header
            if ($header === false) {
                $error = "socket EOF, closing socket...";
                fclose($this->socket);
                $this->socket = null;
                $this->eventManager()->fire("onClose",
                    array(
                        $this->phoneNumber,
                        $error
                    )
                );
            }

            if (strlen($header) == 0) {
                //no data received
                return;
            }
            if (strlen($header) != 3) {
                throw new ConnectionException("Failed to read stanza header");
            }
            $treeLength = (ord($header[0]) & 0x0F) << 16;
            $treeLength |= ord($header[1]) << 8;
            $treeLength |= ord($header[2]) << 0;

            //read full length
            $buff = fread($this->socket, $treeLength);
            //$trlen = $treeLength;
            $len = strlen($buff);
            //$prev = 0;
            while (strlen($buff) < $treeLength) {
                $toRead = $treeLength - strlen($buff);
                $buff .= fread($this->socket, $toRead);
                if ($len == strlen($buff)) {
                    //no new data read, fuck it
                    break;
                }
                $len = strlen($buff);
            }

            if (strlen($buff) != $treeLength) {
                throw new ConnectionException("Tree length did not match received length (buff = " . strlen($buff) . " & treeLength = $treeLength)");
            }
            $buff = $header . $buff;
        } else {
            $this->eventManager()->fire("onDisconnect",
                array(
                    $this->phoneNumber,
                    $this->socket
                ));
        }

        return $buff;
    }

     public function creatVCard($data=array()){
        $v = new vCard();

        $v->set('data', array(
            'first_name' => $data['contact_name'],
            'last_name' => '',
            'cell_tel' => $data['contact_number'],
        ));

        return $v->show();
    }

}