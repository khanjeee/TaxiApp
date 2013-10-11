<?php

class Corporate_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('form');
    }
   
    



 function get_corporate_dropdown($value)
    {   
    	$value=(!empty($value))? $value : 1;
    	$arrGroups=array();
    	
    	$this->db->select('id,name');
     	$query = $this->db->get('corporate');
       
		foreach ($query->result() as $data ){
			
			$arrGroups[$data->id]=$data->name;
		}
		
		
		return form_dropdown('corporate_id', $arrGroups,$value,'id="corporate_id"');
    }
    
    
    function get_corporate_name_by_id($corporate_id)
    {
    	$query = $this->db->get_where('corporate', array('id' => $corporate_id));
    	$result=$query->result();
    	if(!empty($result)){
    		return $result[0]->name;
    	}
    }
    
    
    
    
    
		
}


