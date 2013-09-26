<?php

class Groups_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        
        $this->load->helper('form');
    }
    
    function get_groups_dropdown($value)
    {   
    	$value=(!empty($value))? $value : 1;
    	$arrGroups=array();
    	
    	$this->db->select('id,name');
     	$query = $this->db->get('groups');
       
		foreach ($query->result() as $data ){
			
			$arrGroups[$data->id]=$data->name;
		}
		
		
		return form_dropdown('group_id', $arrGroups,$value);
    }
    
    function get_group_by_id($group_id)
    {
    	$query = $this->db->get_where('groups', array('id' => $group_id));
    	$result=$query->result();
    	if(!empty($result)){
    	return $result[0]->name;
    	}
    }
    
   
		
}


