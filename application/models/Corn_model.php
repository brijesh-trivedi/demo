<?php
if ( !defined('BASEPATH') )
	exit('No direct script access allowed');

class Corn_model extends CI_Model
{
    protected $queues = 'queues';
    protected $inbox = 'inbox';
    
    public function __construct()
    {
        parent::__construct();
    }
     /**
     * Insert Replies to inbox 
     */
    
    public function add($data)
    {
    	$this->db->insert($this->inbox,$data);
	return $this->db->insert_id();
    }
    /**
    * 
    * get sender id how's against receiver reply 
    */
    
  
    
    
    public function get()
    {
        $today=date("Y-m-d");
        $fromDays10 = date('Y-m-d', strtotime('today - 10 days'));
        $this->db->select('queues.sender_number,queues.sender_id,senders.password,proxies.ip_address,proxies.port,proxies.username,proxies.password AS pPassword');
    	$this->db->from('queues');
        $this->db->join('senders', 'queues.sender_id = senders.id');
        $this->db->join('proxies', 'senders.proxy_id = proxies.id');
    	$this->db->where("queues.status", QUEUE_COMPLETE);
        $this->db->where('Date(queues.updated_at) >=', $fromDays10);
        $this->db->where('Date(queues.updated_at) <=', $today);
        $this->db->group_by('queues.sender_id');
    	$query = $this->db->get();
        $result = $query->result();
        return $result;
    }

   
    
}
?>
