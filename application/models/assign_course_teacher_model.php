<?php

class assign_course_Teacher_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
   
 /*    function get_teacher_by_assign_course_id($assign_course_id,$field)
    {
    	 
    	    $query= $this->db->get_where('assign_course_teacher', array('assign_course_id' => $assign_course_id));
    	
    	 $arr=array();
    	 
    	$result=$query->result();
    	foreach ($result as $key=>$data){
    		
    		$arr[]=$data->id;
    	}
 
    	if(!empty($result)){
    		return $arr;
    	}
    } */
     

//2nd param is the field to be retrieved     
    function get_teacher_by_assign_course_id($assign_course_id,$field)
    {	
    	
    	$this->db->select('user_teacher.id,user_teacher.name');
    	$this->db->from('assign_course_teacher');
    	$this->db->join('user_teacher', 'user_teacher.id =assign_course_teacher.teacher_id','inner');
    	$this->db->where('assign_course_teacher.assign_course_id', $assign_course_id);
    	
    	$query = $this->db->get();
    	
    	 $result=$query->result();
    	 
    	if(!empty($result)){
    		return $result[0]->$field;
    	}
    }
    
    

    function insert($post_array,$assign_course_id)
    {
		 /*    	$data = array(
		   'teacher_id' => $post_array['teacher_id'],
		   'assign_course_id' => $assign_course_id 
		);
		
		if($this->db->insert('assign_course_teacher', $data)){
			return 0;
		}  */
    	
    	$teachersArr=array();
    	$dataArr=array();
    		
    	foreach ($post_array['teacher_id'] as $key=>$data){
    		$dataArr['teacher_id']=$data;
    		$dataArr['assign_course_id']=$assign_course_id;
    			
    		$teachersArr[$key]=$dataArr;
    	}
    	//bulk insertion to assign_course_teacher table
    	if($this->db->insert_batch('assign_course_teacher', $teachersArr)){
    		return 0;
    	}
     return 1;
    	
    
    
    }
    	
    
    	function update($post_array,$assign_course_id)
    	{
    		
    		$teachersArr=array();
    		$dataArr=array();
    		$this->db->delete('assign_course_teacher', array('assign_course_id' => $assign_course_id));
    		    	
    		    	 foreach ($post_array['teacher_id'] as $key=>$data){
    			$dataArr['teacher_id']=$data;
    			$dataArr['assign_course_id']=$assign_course_id;
    			    		
    			$teachersArr[$key]=$dataArr;
    		}

    		//print_r($teachersArr); die;
    		//bulk insertion to assign_course_teacher table
    		if($this->db->insert_batch('assign_course_teacher', $teachersArr)){
    			return 0;
    		}
    			 
    		    	  	
    		/*$data = array(
    				'teacher_id' => $post_array['teacher_id'],
    				'assign_course_id' => $assign_course_id
    		);
    	
    		$this->db->where('assign_course_id', $assign_course_id);
    		
    		if($this->db->update('assign_course_teacher', $data)){
    			return 0;
    		}*/
    			 
    		return 1;
    	}
    	
}

