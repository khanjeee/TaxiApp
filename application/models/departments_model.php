<?php

class Departments_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        
        $this->load->library('ion_auth');
    }
    
    function get_departments_dropdown($value)
    {   
    	$value=(!empty($value))? $value : 1;
    	$arrDepartments=array();
    	
    	$this->db->select('id,name');
     	$query = $this->db->get('departments');
       
		foreach ($query->result() as $data ){
			
			$arrDepartments[$data->id]=$data->name;
		}
		
		return form_dropdown('department_id', $arrDepartments,$value);
    }
    
   
    function get_department_by_id($id)
    {
    	$query = $this->db->get_where('departments', array('id' => $id));
    	$result=$query->result();
    	if(!empty($result)){
    	return $result[0]->name;
    	}    
    }  
    
    
		
}


