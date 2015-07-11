<?php
if ( !defined('BASEPATH') )
    exit('No direct script access allowed');

class Message_model extends CI_Model
{
    protected $tableName = 'inbox';


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
        $this->db->select('*,s.phone');
        $this->db->from($this->tableName);
        $this->db->join("senders as s", "sender_id = s.id");
        if(isset($id) && $id != "")
        {
            $this->db->where("id", $id);
        }
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_message_stats()
    {
        $this->db->select('inbox.type,count(inbox.id) AS cnt');
    	$this->db->from('inbox');
        $this->db->group_by('inbox.type');
    	$query = $this->db->get();
        $result = $query->result();
        return $result;
    }


    public function delete($id='')
    {
    }
}
?>
