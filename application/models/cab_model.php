<?php

class Cab_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('form');
    }


   
    
    function get_cab_by_id($cab_id)
    {
    	$query = $this->db->get_where('cabs', array('id' => $cab_id));
    	$result=$query->result();
    	if(!empty($result)){
    	return $result[0]->cab_no;
    	}
    }

   




}   
    
    
    
		



