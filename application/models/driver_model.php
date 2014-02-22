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
    
    function get_cabs_not_in_driver_information_dropdown()
    {
    	$query=$this->db->query('SELECT id,cab_no FROM cabs WHERE id NOT IN (SELECT cab_id FROM driver_information) ');
		
    	$result=$query->result();
    	$arrCab=array();
    	if(!empty($result)){
	    	foreach ($result as $data ){
	    			
	    		$arrCab[$data->id]=$data->cab_no;
	    	}
	    
	    	return form_dropdown("cab_id", $arrCab,NULL,"id='cab_id'");
    	}
    	else {
    		$data['']='None';
    		return form_dropdown("cab_id", $data,NULL,"id='cab_id'");
    	}
    }
    
    function get_driver_name_by_cab_id($cab_id)
    {
    	$query = $this->db->get_where('driver_information', array('cab_id' => $cab_id));
    	$result=$query->result();
    	if(!empty($result)){
    		return $result[0]->name;
    	} 
    }
    
    
    function get_driver_by_cab_provider_id($cab_provider_id)
    {
    
    	$this->db->select('id,name');
    	$query = $this->db->get_where('driver_information', array('cab_provider_id' => $cab_provider_id));
    	$result=$query->result();
    
    			if(!empty($result)){
    	return json_encode($result);
    		 
    	}
    }
    
    function get_user_id_by_cab_provider_id($cab_provider_id)
    {
    
    	$this->db->select('user_id,name');
    	$query = $this->db->get_where('driver_information', array('cab_provider_id' => $cab_provider_id));
    	$result=$query->result();
    
    	if(!empty($result)){
    		return json_encode($result);
    		 
    	}
    }
    
    //first param is the value to be updated and second is the id of the field to be updated
    function update_driver_name($value,$row_id)
    {
	 	$data = array('name' => $value);
	    $this->db->where('cab_id', $row_id);
	    $this->db->update('driver_information',$data);
    }
   
    function get_user_id_by_driver_id($driver_id)
    {
	    $query = $this->db->get_where('driver_information', array('id' => $driver_id));
	    $result=$query->result();
	    if(!empty($result)){
	    	return $result[0]->user_id;
	    }
    }
    
    
    
    function get_cabs_not_in_driver_information($cab_provider_id)
    {
    	$query=$this->db->query("SELECT cabs.`id`,cabs.`cab_no` FROM cabs cabs
									LEFT JOIN driver_information driver_information ON cabs.`id` = driver_information.`cab_id`
									WHERE driver_information.`cab_id` IS NULL
									AND cabs.`cab_provider_id`={$cab_provider_id}");
    			$result=$query->result();
    
    			if(!empty($result)){
    	 
    	return json_encode($result);
    		 
    	}
    }
    
    function get_lisence_code_by_user_id($user_id)
    {
    	$this->db->select('license_code');
    	$query=$this->db->get_where('driver_information', array('user_id' => $user_id));
    	$result=$query->result();
    	if(!empty($result)){
    		return $result[0]->license_code;
    	}
    }
    
    function get_cab_provider_by_user_id($user_id)
    {
    	$this->db->select('cab_provider_id');
    	$query=$this->db->get_where('driver_information', array('user_id' => $user_id));
    	$result=$query->result();
    	if(!empty($result)){
    		return $result[0]->cab_provider_id;
    	}
    }
    
    function update_cab_id($cab_id){
    	
    	$data = array('cab_id' => null);
    	$this->db->where('cab_id', $cab_id);
    	$this->db->update('driver_information',$data);
    }
    




}   
    
    
    
		



