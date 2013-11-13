<?php

class Dispatcher_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('form');
    }
    /*value parameter is passed when the function is called on edit form*/
  
    function get_dispatcher_dropdown($value)
    {
    	$value=(!empty($value))? $value : 1;
    	$arrDispatcher=array();
    	 
    	$this->db->select('id,name');
    	$query = $this->db->get('dispatcher_information');
    	 
    	foreach ($query->result() as $data ){
    			
    		$arrDispatcher[$data->id]=$data->name;
    	}
    
    	return form_dropdown("dispatcher_id", $arrDispatcher,$value,"id='dispatcher_dd'");
    }
    
    

   
    
    function get_dispatcher_by_id($dispatcher_id)
    {
    	$query = $this->db->get_where('dispatcher_information', array('id' => $dispatcher_id));
    	$result=$query->result();
    	if(!empty($result)){
    	return $result[0]->name;
    	}
    }

    




}   
    
    
    
		



