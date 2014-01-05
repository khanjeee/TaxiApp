<?php

class Journey_type_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('form');
    }


   
    
  function get_journey_type_dropdown($value)
    {
    	
    	$value=(!empty($value))? $value : 1;
    	$journeyType=array();
    	$journeyType[0]="Select";
    	 
    	$this->db->select('id,journey_type');
    	$query = $this->db->get('journey_type');
    	 
    	foreach ($query->result() as $data ){
    			
    		$journeyType[$data->journey_type]=$data->journey_type;
    	}
    
    	return form_dropdown("journey_type", $journeyType,$value,"id=journey_type_dd");
    }

   




}   
    
    
    
		



