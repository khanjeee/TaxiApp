<?php

class Cab_provider_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('form');
    }
    /*value parameter is passed when the function is called on edit form*/
  
    function get_cab_provider_dropdown($value,$type=null)
    {
    	$type=(!empty($type))? 'multiple' : '';
    	$form_name=(!empty($type))? 'cab_provider_id[]' : 'cab_provider_id';
    	$value=(!empty($value))? $value : 1;
    	$arrCabProvider=array();
    	 
    	$this->db->select('id,name');
    	$query = $this->db->get('cab_provider');
    	 
    	foreach ($query->result() as $data ){
    			
    		$arrCabProvider[$data->id]=$data->name;
    	}
    
    	return form_dropdown("{$form_name}", $arrCabProvider,$value,"id='cab_provider_dd' {$type}");
    }
    
    function get_cab_provider_dropdown_multiple_edit($corporate_id)
    {
    	
    	$arrCabProvider=array();
    	$arrCabProviderSelected=array();
    
    	$this->db->select('id,name');
    	$query = $this->db->get('cab_provider');
    
    	foreach ($query->result() as $data ){
    		 
    		$arrCabProvider[$data->id]=$data->name;
    	}
    	
    	$query2 = $this->db->get_where('corporate_cab_provider', array('corporate_id' => $corporate_id));
    	$result2=$query2->result();
    	foreach ($result2 as $data ){
    	
    		$arrCabProviderSelected[]=$data->cab_provider_id;
    	}
   
    	return form_multiselect("cab_provider_id[]", $arrCabProvider,$arrCabProviderSelected);
    }

   
    
    function get_cab_provider_by_id($cab_provider_id)
    {
    	$query = $this->db->get_where('cab_provider', array('id' => $cab_provider_id));
    	$result=$query->result();
    	if(!empty($result)){
    	return $result[0]->name;
    	}
    }

    function get_cabs_by_driver_id($driver_id)
    {
    
    	$query=$this->db->query("SELECT id,cab_no FROM cabs 
								WHERE cab_provider_id=(SELECT cab_provider_id FROM driver_information WHERE `user_id`={$driver_id} limit 1)
								AND id NOT IN (SELECT cab_id FROM driver_information)");
    	    	$result=$query->result();
    
    	if(!empty($result)){
    		 
    		return json_encode($result);
    		 
    	}
    }




}   
    
    
    
		



