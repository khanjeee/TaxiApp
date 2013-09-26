<?php

class Users_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        
        $this->load->library('ion_auth');
    }
    
    function get_users_dropdown($value)
    {   
    	$value=(!empty($value))? $value : 1;
    	$arrUsers=array();
    	
    	$this->db->select('id,first_name');
     	$query = $this->db->get('users');
       
		foreach ($query->result() as $data ){
			
			$arrUsers[$data->id]=$data->first_name;
		}
		
		return form_dropdown('user_id', $arrUsers,$value);
    }
    
    //returns first_name of the uid passed
    function get_user_by_id($user_id)
    {
    	$query = $this->db->get_where('users', array('id' => $user_id));
    	$result=$query->result();
    	if(!empty($result)){
    	return $result[0]->first_name;
    	}
    }
    
    //returns user id off the logged in user
    function get_user_id() {
    	return $this->ion_auth->user()->row()->id;
    
    }
    
    
    
		
}


