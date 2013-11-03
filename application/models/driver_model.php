<?php

class Driver_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('form');
    }
    /*value parameter is passed when the function is called on edit form*/
  
    function get_driver_dropdown($value,$type=null)
    {
    	$type=(!empty($type))? 'multiple' : '';
    	$form_name=(!empty($type))? 'driver_id[]' : 'driver_id';
    	$value=(!empty($value))? $value : 1;
    	$arrDriver=array();
    	 
    	$this->db->select('id,name');
    	$query = $this->db->get('driver_information');
    	 
    	foreach ($query->result() as $data ){
    			
    		$arrDriver[$data->id]=$data->name;
    	}
    
    	return form_dropdown("{$form_name}", $arrDriver,$value,"id='driver_dd' {$type}");
    }
    
   
    
    function get_cab_provider_by_id($cab_provider_id)
    {
    	$query = $this->db->get_where('cab_provider', array('id' => $cab_provider_id));
    	$result=$query->result();
    	if(!empty($result)){
    	return $result[0]->name;
    	}
    }

    




}   
    
    
    
		



