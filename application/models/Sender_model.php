<?php
if ( !defined('BASEPATH') )
	exit('No direct script access allowed');

class Sender_model extends CI_Model
{
    protected $tableName = 'senders';
    protected $sendersGroupTableName = 'sender_master_groups';
    protected $sendersGroup = 'sender_groups';
    protected $proxytableName='proxies';


    public function __construct()
    {
        parent::__construct();
    }

    public function add($data)
    {
    	$this->db->insert($this->tableName,$data);
	return $this->db->insert_id();
    }
    /**
     * Add Value in sender_group table 
     */
    public function addSenderGroupValue($data)
    {  
        $this->db->insert($this->sendersGroup,$data);
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
    /**
     * update sender_group
     */
     public function updateSubGroupValue($data)
    {
    	if($data['sender_id']!="")
        {
    		$this->db->where("sender_id", $data['sender_id']);
    	}
    	if($this->db->update($this->sendersGroup,$data))
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

    public function getTotalSenders(){
        $this->db->select('COUNT(*) as totalSenders');
        $this->db->from($this->tableName);
        $this->db->where("status", '1');
        $query = $this->db->get();
        $result = $query->result();
        return $result;   
    }

    /**
     * get data from sender_group
     */
    public function getSubGroupValue($id="")
    {
    	$this->db->select('sender_group_id');
    	$this->db->from($this->sendersGroup);
    	if(isset($id) && $id != "")
        {
    		$this->db->where("sender_id", $id);
    	}
    	$query = $this->db->get();
		$result = $query->result();
		return $result;
    }
    
    public function delete($id='')
    {
    	
        if($this->db->delete($this->tableName, array('id' => $id)) && $this->db->delete($this->sendersGroup, array('sender_id' => $id)))
        {
    		return true;
    	}
		return false;	
    }
    public function getGroupData($id = '')
    {
        $this->db->select('*');
        $this->db->from($this->sendersGroupTableName);
        if(isset($id) && $id != "")
        {
            $this->db->where("id", $id);
        }
        $query = $this->db->get();
        $result = $query->result();
        return $result;

    }
    public function getAllParentGroups()
    {
        $this->db->select('*');
        $this->db->from($this->sendersGroupTableName);
        $this->db->where("parent_group_id", 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function getParent($id = '')
    {
        $this->db->select('*');
        $this->db->from($this->sendersGroupTableName);
        $this->db->where("id", $id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function getAllChildrenGroups($parent_id='')
    {
        $this->db->select("*, (select count(*) from $this->sendersGroupTableName as SG2 where SG2.parent_group_id = SG1.id) as subGroupCount");
        $this->db->from($this->sendersGroupTableName ." as SG1" );
        $this->db->where("parent_group_id", $parent_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function addSenderGroup($data){
        $this->db->insert($this->sendersGroupTableName,$data);
        return $this->db->insert_id();
    }
    public function deleteGroup($id='')
    {
        return $this->db->delete($this->sendersGroupTableName, array('id' => $id));
    }
    public function updateSenderGroup($data)
    {
        if($data['id']!="")
        {
            $this->db->where("id", $data['id']);
        }
        if($this->db->update($this->sendersGroupTableName,$data))
        {
            return true;
        }
        return false;   
    }
    public function getProxies()
    {
    	$this->db->select('*');
    	$this->db->from($this->proxytableName);
    	$this->db->where("status", ACTIVE);
    	$this->db->order_by("use_count", "asc");
    	$query = $this->db->get();
	$result = $query->result();
	return $result;
    }
    public function getLeastCountProxies()
    {
    	$this->db->select('*');
    	$this->db->from($this->proxytableName);
    	$this->db->where("status", ACTIVE);
    	$this->db->order_by("use_count", "asc");
        $this->db->limit(1);
    	$query = $this->db->get();
	$result = $query->result();
	return $result;
    }
     public function getSenderId($id="")
    {
    	$this->db->select('sender_id');
    	$this->db->from($this->sendersGroup);
    	if(isset($id) && $id != "")
        {
    		$this->db->where("sender_group_id", $id);
    	}
    	$query = $this->db->get();
		$result = $query->result();
		return $result;
    }
    public function getSenderProxy()
    {
    	$this->db->select('senders.id,senders.phone,senders.password,senders.nickname,proxies.ip_address,proxies.port,proxies.username,proxies.password AS pPassword');
        $this->db->from('senders');
        $this->db->join('proxies', 'senders.proxy_id = proxies.id');
        $query = $this->db->get();
		$result = $query->result();
		return $result;
    }
    
}
?>
