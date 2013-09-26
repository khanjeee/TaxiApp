<?php

class attendance_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
   
  
    function check_attendance($post_array) // checks if attendance is already marked for a particular course
    {
    	
    	$query = $this->db->get_where('attendance', array('assign_course_id' => $post_array['assign_course_id'],'date'=>$post_array['date']));
    
    	$result=$query->result();
    	if(!empty($result)){
    		return 0;
    	}
    	else{
    		return 1;
    	}
    }
//return 0 if marked else return 1 

}

