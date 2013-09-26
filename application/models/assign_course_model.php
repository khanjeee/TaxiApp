<?php

class assign_Course_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
   
   //checks for duplicate entries in db return 1 if exist else 0
    function check_duplicate($data,$teacher_id,$assign_course_id)
    {	
    	/* $data2 = array(
    				'teacher_id' => $teacher_id,
    				'assign_course_id' => $assign_course_id
    		);
    	$query2 = $this->db->get_where('assign_course_teacher',$data2);
    	$result2=$query2->result(); */
    	
    	
    	$query = $this->db->get_where('assign_course',$data);
    	$result=$query->result();
    	//return (empty($result)|| empty($result2)) ? 0 : 1;
    	return (empty($result)) ? 0 : 1;
    }
    
  
    
    ////if items above in $data are peresent in assign_course insert student and assign_course id to student_course
    function is_assigned($data,$user_student_id)
    {
    	$query = $this->db->get_where('assign_course',$data);
    	$result=$query->result();
    	
    	 if(!empty($result)){
    	 	//inserting student and assign_course id to student_course
    	 	$dataArr = array('student_id' => $user_student_id,'assign_course_id' => $result[0]->id);
    	 	$this->db->insert('student_course', $dataArr);
    	 	
    	 }
    }
    
    //cehcks if years ,section or batch is updated during update and return 0 incase of change else 1
    function check_items($data)
    {
    	$query = $this->db->get_where('assign_course',$data);
    	$result=$query->result();
    	 
    	if(!empty($result)){
    		//if not empty means year,section,batch has not been changed so return 1
    		return 1 ;
    		 
    	}
    	else{
    		//delete all entries from student_course where id = $data['id'] because setion year or batch has been updated
    		$this->db->delete('student_course', array('assign_course_id ' => $data['id']));
    		return 0;
    	}
    }
    function get_assigned_course_dropdown($value=1){

    	$arrCourses=array();
    	    	
    	$query=$this->db->query("SELECT a.id,c.name
    			FROM assign_course a
    			INNER JOIN courses c ON a.course_id = c.id
    			GROUP BY c.name");
    	
    	$result=$query->result();
    	if(!empty($result)){
    		
    		foreach ($result as $data ){
    				
    			$arrCourses[$data->id]=$data->name;
    		}
    		
    		return form_dropdown('assign_course_id', $arrCourses,$value,'id="assign_course"');
    		 
    	}
    }

    function get_assigned_course_dropdownByYearSection($year_id,$section_id){

        $arrCourses=array();

        $query=$this->db->query("SELECT a.id,c.name
    			FROM assign_course a
    			INNER JOIN courses c ON a.course_id = c.id
    			WHERE a.year_id= ? AND a.section_id = ?
    			GROUP BY c.name", array($year_id,$section_id));

        $result=$query->result();
        if(!empty($result)){

            foreach ($result as $data ){

                $arrCourses[$data->id]=$data->name;
            }

            return form_dropdown('assign_course_id', $arrCourses,1,'id="assign_course"');

        }
    }

    function get_assigned_course_by_id($id)
    {
    	$query=$this->db->query("SELECT a.id, c.name
								FROM assign_course a
								INNER JOIN courses c ON a.course_id = c.id
								WHERE a.id={$id};");
    	$result=$query->result();
    	if(!empty($result)){
    		return $result[0]->name;
    	}
    }

    function get_assign_course_by_id($id){
        $query=$this->db->query("SELECT a.*
								FROM assign_course a
								WHERE a.id={$id};");
        $result=$query->result();
        if($result)
            return $result[0];
        else
            return null;
    }

    function get_course_teachers($assign_course_id)
    {

        $query=$this->db->query("SELECT t.*
                                FROM assign_course a
                                INNER JOIN assign_course_teacher as act on a.id = act.assign_course_id
                                INNER JOIN user_teacher as t on t.id = act.teacher_id
                                WHERE a.id = ? and a.status =1
                                ORDER BY a.id DESC", array($assign_course_id));

        $ret = $query->result_array();
        return $ret;
    }

    function get_assigned_courses_by_year($post_array)
    {
    	$query=$this->db->query("SELECT a.id, c.name
								FROM assign_course a
								INNER JOIN courses c ON a.course_id = c.id
								WHERE a.year_id={$post_array['year_id']}");
    	$result=$query->result();
    	if(!empty($result)){
    		return json_encode($result);
    	}
    }

//    function get_assigned_courses_by_year($post_array)
//    {
//        $query=$this->db->query("SELECT a.id, c.name
//								FROM assign_course a
//								INNER JOIN courses c ON a.course_id = c.id
//								WHERE a.year_id={$post_array['year_id']}");
//        $result=$query->result();
//        if(!empty($result)){
//            return json_encode($result);
//        }
//    }
}

