<?php

if ( !defined('BASEPATH') )
	exit('No direct script access allowed');

class Campaigns_model extends CI_Model
{
    protected $tableName = 'campaigns';
    protected $queueTableName = 'queues';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function addCampaign($data){
    	$this->db->insert($this->tableName,$data);
		return $this->db->insert_id();
    }
    public function get($id="")
    {
        $this->db->select('*');
        $this->db->from($this->tableName);
        if(isset($id) && $id != "")
        {
            $this->db->where("id", $id);
        }
        $this->db->order_by("id", 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function deleteCampaign($campaign_id=''){
        if($this->db->delete($this->queueTableName, array('campaign_id' => $campaign_id)) && $this->db->delete($this->tableName, array('id' => $campaign_id))){
            return true;
        }else{
            return false;
        }
    }
    public function updateCampaign($data=array()){
         if($data['id']!=""){
            $this->db->where("id", $data['id']);
        }
        if($this->db->update($this->tableName,$data)){
            return true;
        }
        return false;  
    }

}