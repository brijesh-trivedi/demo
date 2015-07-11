<?php

if ( !defined('BASEPATH') )
	exit('No direct script access allowed');

class Proxy_model extends CI_Model {

    public $perPage = NULL;

	public function __construct(){
        parent::__construct();
    }

    public function addProxy($data){
    	
    	$this->db->insert('proxies',$data);
			
		return $this->db->insert_id();
    }
    public function updateProxy($data){
    	if($data['id']!=""){
    		$this->db->where("id", $data['id']);
    	}
    	if($this->db->update('proxies',$data)){
    		return true;
    	}
		return false;			
    }
    public function getProxyData($id=""){
    	$this->db->select('*');
    	$this->db->from('proxies');
    	if(isset($id) && $id != ""){
    		$this->db->where("id", $id);
    	}
    	$query = $this->db->get();
		$result = $query->result(); 

		return $result;
    }

    public function getProxyDataQueryWithCriteria($criteria="", $limit=null, $start=0) {

        $this->db->select('*');
        $this->db->from('proxies');
        if(isset($criteria) && count($criteria) > 0){
            foreach ($criteria as $key => $value) {
                $this->db->where($key, $value);
            }
        }

        if( is_null($limit) )
        {
            $this->db->offset($start);
        }
        else
        {
            $this->db->limit($limit, $start);
        }

        return $this->db;
    }
    public function getProxyDataCountWithCriteria($criteria="", $limit=null, $start=0) {

        $this->getProxyDataQueryWithCriteria( $criteria, $limit, $start );

        return $this->db->count_all_results();
    }
    public function getProxyDataWithCriteria($criteria="", $limit=null, $start=0){

        $this->getProxyDataQueryWithCriteria( $criteria, $limit, $start );
        $query = $this->db->get();
        $result = $query->result(); 
        
        if($result)
            return $result;
        else
            return false;
    }
    public function getCustomData()
    {
        $resultData = array();
        $this->db->select('count(*) as totalCount');
        $this->db->from('proxies');
        $query = $this->db->get();
        $result = $query->result(); 
        $resultData['totalCount'] = $result[0]->totalCount;
        $this->db->reset_query();
        
        $this->db->select('count(*) as activeCount');
        $this->db->from('proxies');
        $this->db->where('status', '1');
        $query = $this->db->get();
        $result = $query->result(); 
        $resultData['activeCount'] = $result[0]->activeCount;

        return $resultData;

    }
    public function deleteProxy($id=''){
    	return $this->db->delete('proxies', array('id' => $id)); 
    }
}
?>