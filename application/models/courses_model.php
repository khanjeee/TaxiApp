<?php

class Courses_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('form');
    }
    /*value parameter is passed when the function is called on edit form*/
    function get_courses_dropdown($value)
    {   
    	
    	$value=(!empty($value))? $value : 1;
    	$arrCourses=array();
    	
    	$this->db->select('id,name');
     	$query = $this->db->get('courses');
       
		foreach ($query->result() as $data ){
			
			$arrCourses[$data->id]=$data->name;
		}
		
		return form_dropdown('course_id', $arrCourses,$value,'id="courses"');
    }

    function get_course($id)
    {
        $query = $this->db->query('SELECT s.*,y.year,sc.section,d.name as department FROM courses s
                                    INNER JOIN years y on y.id = s.year_id
                                    INNER JOIN sections sc on sc.id = s.section_id
                                    INNER JOIN departments d on d.id = s.department_id
                                    WHERE s.id = ? ',array($id));
        $result=$query->result();
        if(!empty($result)){
            return $result[0];
        }else
            return null;
    }
    
    function get_course_by_id($course_id)
    {
    	$query = $this->db->get_where('courses', array('id' => $course_id));
    	$result=$query->result();
    	if(!empty($result)){
    	return $result[0]->name;
    	}
    }

    function get_all_courses($year, $section, $student_id)
    {
        $query = $this->db->query('SELECT s.*,ac.id as assign_course_id, y.year,sec.section,d.name as department FROM student_course sc
                                    INNER JOIN assign_course ac on ac.id = sc.assign_course_id
                                    INNER JOIN courses s on s.id = ac.course_id
                                    INNER JOIN years y on y.id = s.year_id
                                    INNER JOIN sections sec on sec.id = s.section_id
                                    INNER JOIN departments d on d.id = s.department_id
                                    WHERE ac.year_id = ? AND ac.section_id = ? AND sc.student_id = ? ', array($year,$section, $student_id));

        $ret = $query->result_array();
        return $ret;
    }

   function get_course_by_batch_section($post_array)
    {	
    	$query=$this->db->query("SELECT a.id,c.name 
				    			FROM assign_course a
				    			INNER JOIN courses c ON a.course_id = c.id
    							WHERE a.section_id={$post_array['section_id']}
    							AND a.batch_year={$post_array['batch_year']}
				    			GROUP BY c.name");
    	
    	
    	
    	//$query = $this->db->get_where('assign_course', array('section_id' => $post_array['section_id'],
    													//	'batch_year' => $post_array['batch_year']));
    	$result=$query->result();
    	if(!empty($result)){
    		return json_encode($result);
    	}
    	
    }
    
    
    function get_courses_by_section($post_array)
    {
    	$query=$this->db->query("SELECT id,name
    							FROM courses 
    							WHERE section_id={$post_array['section_id']}");
    			 
    			 
    			 
    			//$query = $this->db->get_where('assign_course', array('section_id' => $post_array['section_id'],
    					//	'batch_year' => $post_array['batch_year']));
    	$result=$query->result();
    					if(!empty($result)){
    					return json_encode($result);
    }
     
    }
    
    function get_courses_by_year($post_array)
    {	$this->db->select('id, name');
    	$query = $this->db->get_where('courses', array('year_id' => $post_array['year_id']));
    	$result=$query->result();
    					if(!empty($result)){
    					return json_encode($result);
    }
     
    }
    
    function get_year_by_course_id($course_id)
    {
    	$this->db->select('year_id');
    	$query = $this->db->get_where('courses', array('id' => $course_id));
    	$result=$query->result();
    	if(!empty($result)){
    		return $result[0]->year_id;
    	}
    	 
    }


}   
    
    
    
		



