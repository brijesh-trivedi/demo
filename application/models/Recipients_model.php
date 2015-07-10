<?php
if ( !defined('BASEPATH') )
	exit('No direct script access allowed');

class Recipients_model extends CI_Model
{
    protected $tableName = 'recipients';
    protected $recipientGroupTableName = 'recipient_master_groups';
     protected $recipientGroup = 'recipient_groups';

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
    	if($data['recipient_id']!="")
        {
    		$this->db->where("recipient_id", $data['recipient_id']);
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
    		$this->db->where("recipient_id", $id);
    	}
    	$query = $this->db->get();
		$result = $query->result();
		return $result;
    }
    
    /**
     * Add Value in recipient_groups table 
     */
    public function addRecipientGroupValue($data)
    {  
        $this->db->insert($this->recipientGroup,$data);
	return $this->db->insert_id();
    }
     /**
     * update recipient_groups
     */
     public function updateSubGroupValue($data)
    {
    	if($data['recipient_id']!="")
        {
    		$this->db->where("recipient_id", $data['recipient_id']);
    	}
    	if($this->db->update($this->recipientGroup,$data))
        {
    		return true;
    	}
		return false;			
    }
     /**
     * get data from sender_group
     */
    public function getSubGroupValue($id="")
    {
    	$this->db->select('recipient_group_id');
    	$this->db->from($this->recipientGroup);
    	if(isset($id) && $id != "")
        {
    		$this->db->where("recipient_id", $id);
    	}
    	$query = $this->db->get();
		$result = $query->result();
		return $result;
    }
    public function delete($id='')
    {
    	if($this->db->delete($this->tableName, array('recipient_id' => $id)) && $this->db->delete($this->recipientGroup, array('recipient_id' => $id)))
        {
    		return true;
    	}
		return false;	
    }
    public function getRecipientsData($id=""){
    	$this->db->select('*');
    	$this->db->from('recipients');
    	if(isset($id) && $id != ""){
    		$this->db->where("id", $id);
    	}
    	$query = $this->db->get();
	$result = $query->result(); 
        return $result;
    }

    public function getAllParentGroups()
    {
        $this->db->select('*');
        $this->db->from($this->recipientGroupTableName);
        $this->db->where("parent_group_id", 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
     public function getParent($id = '')
    {
        $this->db->select('*');
        $this->db->from($this->recipientGroupTableName);
        $this->db->where("id", $id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function getAllChildrenGroups($parent_id='')
    {
        $this->db->select("*, (select count(*) from $this->recipientGroupTableName as RG2 where RG2.parent_group_id = RG1.id) as subGroupCount");
        $this->db->from($this->recipientGroupTableName ." as RG1" );
        $this->db->where("parent_group_id", $parent_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function addRecipientGroup($data){
        $this->db->insert($this->recipientGroupTableName,$data);
        return $this->db->insert_id();
    }
    public function deleteGroup($id='')
    {
        /*Check if the group is main group*/
        $groupDetails = $this->getGroupData($id);
        
        /* Get all sub group of main group*/
        $subGroupDetails = $this->getAllChildrenGroups($id);  
        if(count($subGroupDetails) > 0){          
            for ($i=0; $i < count($subGroupDetails); $i++) { 
                $subGroupId = $subGroupDetails[$i]->id; 
                // delete all sub group and recipients relation
                $this->db->delete($this->recipientGroup, array('recipient_group_id' => $subGroupId));
            }
            // delete all sub group 
            $allSubGrp = getInArray($subGroupDetails,'id');
            $this->db->where_in('id', $allSubGrp);
            $this->db->delete($this->recipientGroupTableName);
        }
        // Delete main group
        $this->db->where('id', $id);
        if($this->db->delete($this->recipientGroupTableName)){
            return true;
        }else{
            return false;
        }
        //exit;
    }
    public function updateRecipientGroup($data)
    {
        if($data['id']!="")
        {
            $this->db->where("id", $data['id']);
        }
        if($this->db->update($this->recipientGroupTableName,$data))
        {
            return true;
        }
        return false;   
    }
    public function getGroupData($id = '')
    {
        $this->db->select('*');
        $this->db->from($this->recipientGroupTableName);
        if(isset($id) && $id != "")
        {
            $this->db->where("id", $id);
        }
        $query = $this->db->get();
        $result = $query->result();
        return $result;

    }

    public function getRecipentDataWithGroupValue($sub_group_id=''){
        $this->db->select('*');
        $this->db->from($this->tableName. " as r");
        $this->db->join($this->recipientGroup. " as rg", "r.recipient_id = rg.recipient_id" , "LEFT");
        $this->db->where("rg.recipient_group_id", $sub_group_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
}
?>