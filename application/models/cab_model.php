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
    
    function get_cab_no_by_cab_provider_id_dropdown($value,$id)
    {
    	
    	$query_1 = $this->db->get_where('driver_information', array('id' => $id));
    	$result=$query_1->result();
    	$cab_provider_id=$result[0]->cab_provider_id;
    	
    	
    	$value=(!empty($value))? $value : 1;
    	$arrGroups=array();
    	 
    	$this->db->select('id,cab_no');
    	$this->db->where('cab_provider_id', $cab_provider_id); 
    	$query = $this->db->get('cabs');
    	 
    	foreach ($query->result() as $data ){
    			
    		$arrGroups[$data->id]=$data->cab_no;
    	}
    
    
    	return form_dropdown('cab_id', $arrGroups,$value,'id="cab_id"');
    }

   




}   
    
    
    
		



