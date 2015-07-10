<?php
if ( !defined('BASEPATH') )
	exit('No direct script access allowed');

class Settings_model extends CI_Model
{
    protected $tableName = 'settings';
    
    public function __construct()
    {
        parent::__construct();
    }

    public function add($data)
    {
    	$this->db->insert($this->tableName,$data);
		return $this->db->insert_id();
    }
    public function update($data)
    {
    	if($data['id']!="")
        {
    		$this->db->where("id", $data['id']);
    	}
    	if($this->db->update($this->tableName,$data))
        {
    		return true;
    	}
		return false;			
    }
    public function get($id="")
    {
    	$this->db->select('*');
    	$this->db->from($this->tableName);
    	if(isset($id) && $id != "")
        {
    		$this->db->where("id", $id);
    	}
    	$query = $this->db->get();
		$result = $query->result();
		return $result;
    }
    
   
    public function delete($id='')
    {
    	if($this->db->delete($this->tableName, array('id' => $id)))
        {
    		return true;
    	}
		return false;	
    }
}
?>