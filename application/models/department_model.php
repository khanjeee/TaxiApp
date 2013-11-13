<?php

class Department_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('form');
    }
    /*value parameter is passed when the function is called on edit form*/
  
    function get_department_dropdown($value)
    {
    	$value=(!empty($value))? $value : 1;
    	$arrDepartment=array();
    	 
    	$this->db->select('id,name');
    	$query = $this->db->get('department');
    	 
    	foreach ($query->result() as $data ){
    			
    		$arrDepartment[$data->id]=$data->name;
    	}
    
    	return form_dropdown("department_id", $arrDepartment,$value,"id='department_dd'");
    }
    
    

   
    
    function get_department_by_id($department_id)
    {
    	$query = $this->db->get_where('department', array('id' => $department_id));
    	$result=$query->result();
    	if(!empty($result)){
    	return $result[0]->name;
    	}
    }

    




}   
    
    
    
		



