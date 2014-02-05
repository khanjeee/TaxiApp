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
    	if($value!=1){
    	$this->db->where('corporate_id',$value);
    	}
    	$query = $this->db->get('journey_type');
    	 
    	foreach ($query->result() as $data ){
    			
    		$journeyType[$data->journey_type]=$data->journey_type;
    	}
    
    	return form_dropdown("journey_type", $journeyType,$value,"id=journey_type_dd");
    }
    
    
    
    function get_journey_types_by_corporate_json($corporate_id)
    {
    
    	$this->db->select('id,journey_type');
    	$this->db->where('corporate_id',$corporate_id);
    	$query = $this->db->get('journey_type');
    	$result=$query->result();
    
    	if(!empty($result)){
    		 
    		return json_encode($result);
    		 
    	}
    }

   




}   
    
    
    
		



