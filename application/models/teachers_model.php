<?php

class Teachers_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('form');
    }
    /*value parameter is passed when the function is called on edit form*/
    /*2nd param for the type of slection eg multiple*/
    function get_teachers_dropdown($value,$type=null)
    {   
    	$type=(!empty($type))? 'multiple' : '';
    	$form_name=(!empty($type))? 'teacher_id[]' : 'teacher_id';
    	$value=(!empty($value))? $value : 1;
    	$arrTeachers=array();
    	
    	$this->db->select('id,name');
     	$query = $this->db->get('user_teacher');
       
		foreach ($query->result() as $data ){
			
			$arrTeachers[$data->id]=$data->name;
		}
		
		return form_dropdown("{$form_name}", $arrTeachers,$value,"id='teachers_dd' {$type}");
    }
    
    
    function get_teacher_by_id($teacher_id)
    {
    	$query = $this->db->get_where('user_teacher', array('id' => $teacher_id));
    	$result=$query->result();
    	if(!empty($result)){
    	return $result[0]->name;
    	}
    }
    
    function get_teachers_by_course_id($course_id)
    {
    	
    	/*
    	 * SELECT * 
FROM  `user_teacher` 
INNER JOIN  `courses` ON user_teacher.department_id = courses.department_id
AND courses.id =12
LIMIT 0 , 30
*/
		$this->db->select('user_teacher.id,user_teacher.name');
		$this->db->from('user_teacher');
		$this->db->join('courses', 'user_teacher.department_id =courses.department_id','inner');
		$this->db->where('courses.id', $course_id);
		
		$query = $this->db->get();
		$result=$query->result();
		
		if(!empty($result)){
			
			return json_encode($result);
			
		}
		
		
    }
    
    
    //returns teacher row in form of object required params id
    
    function get_teacher_row($id)
    {
    	$query = $this->db->get_where('user_teacher', array('id' => $id));
    	$result=$query->result();
    	return $result[0];
    }
    
    
		
}


