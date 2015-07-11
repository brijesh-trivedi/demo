<?php

if ( !defined('BASEPATH') )
	exit('No direct script access allowed');

class Queues_model extends CI_Model
{
    protected $tableName = 'queues';
    protected $campaignTableName = 'campaigns';
    protected $proxyTableName = 'proxies';
    protected $senderTableName = 'senders';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function addQueue($data){
    	$this->db->insert($this->tableName,$data);
		return $this->db->insert_id();
    }
    public function updateQueue($data=array()){
       
        if($data['id']!=""){
            $this->db->where("id", $data['id']);
        }
        if($this->db->update($this->tableName,$data)){
            return true;
        }
        return false;           

    }
    public function getQueueDetailsForCampaign($campaign_id='',$execute=false){
        $this->db->select('q.*, c.* ,p.ip_address as proxy_ip, p.port as proxy_port, p.username as proxy_username, p.password as proxy_password, c.name, c.message_type,s.password as wpassword,s.nickname, q.id as queue_id');
        $this->db->from($this->tableName. " as q");
        $this->db->join($this->campaignTableName. " as c", "q.campaign_id = c.id");
        $this->db->join($this->senderTableName. " as s", "s.id = q.sender_id");
        $this->db->join($this->proxyTableName. " as p", "p.id = s.proxy_id");
        $this->db->where("q.campaign_id", $campaign_id);
        if($execute){
            $this->db->where("q.status !=", 2);    
        }
        $query = $this->db->get();
        $result = $query->result();
        
        return $result;
    }

}