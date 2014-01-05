<?php

class Users_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        
        $this->load->library('ion_auth');
    }
    
    
    function get_users_by_corporate_dropdown($corporate_id)
    {
    	$value=(!empty($value))? $value : 1;
    	$arrUsers=array();
    	 
    	$this->db->select('id,first_name');
    	$query=$this->db->get_where('users', array('corporate_id' => $corporate_id));
    	
    	 
    	foreach ($query->result() as $data ){
    			
    		$arrUsers[$data->id]=$data->first_name;
    	}
    
    	return form_dropdown('user_id', $arrUsers,$value,'id="user_id"');
    }
    
    function get_users_by_group_id_dropdown($group_id)
    {
    	$value=(!empty($value))? $value : 1;
    	$arrUsers=array();
    
    	$this->db->select('id,first_name');
    	$query=$this->db->get_where('users', array('group_id' => $group_id));
    	 
    
    	foreach ($query->result() as $data ){
    		 
    		$arrUsers[$data->id]=$data->first_name;
    	}
    
    	return form_dropdown('user_id', $arrUsers,$value,'id="user_id"');
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
		
		return form_dropdown('user_id', $arrUsers,$value,'id="user_id"');
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
    
    function get_first_name_by_id($user_id)
    {
    	$query = $this->db->get_where('users', array('id' => $user_id));
    	$result=$query->result();
    	if(!empty($result)){
    		return $result[0]->first_name;
    	}
    }
    
    function get_last_name_by_id($user_id)
    {
    	$query = $this->db->get_where('users', array('id' => $user_id));
    	$result=$query->result();
    	if(!empty($result)){
    		return $result[0]->last_name;
    	}
    }
    
    
    //returns first_name of the uid passed
    function get_corporate_id($user_id)
    {
    	$query = $this->db->get_where('users', array('id' => $user_id));
    	$result=$query->result();
    	if(!empty($result)){
    		return $result[0]->corporate_id;
    	}
    }
    //returns user id off the logged in user
    function get_user_id() {
    	return $this->ion_auth->user()->row()->id;
    
    }
    
    function get_corporate_users($corporate_id)
    {
    	 
    	$this->db->select('id,first_name');
    	$query=$this->db->get_where('users', array('corporate_id' => $corporate_id));
    	$result=$query->result();
    
    	if(!empty($result)){
    		 
    		return json_encode($result);
    		 
    	}
    }
    
    function update_first_last_name($first_name,$last_name,$row_id)
    {
    	$data = array(
    			'first_name' => $first_name,
    			'last_name' =>$last_name
    	);
    	
    	$this->db->where('id', $row_id);
    	$this->db->update('users',$data);
    }
    
    
    //checks for duplicate entries in db return 1 if exist else 0
    function check_duplicate($value,$row_id)
    {
    	$data['username']=$value;
    	$query = $this->db->get_where('users',$data);
    	$result=$query->result();
    	
    	if(empty($result) || ($result[0]->id==$row_id)){ // if it exists in db return 1 else 0
    		return 0;
    	}
    	else{
    		return 1;
    	}
    }
    
    
    
    
		
}


