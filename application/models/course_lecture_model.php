<?php

class course_Lecture_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
  
    //generates dropdown for coming and past 3 years
    function get_topic_dropdown($value=NULL)
    {
    	$value=(!empty($value))? $value : 1;
    	$arrTopic=array();
    	 
    	$this->db->select('id,topic');
    	$query = $this->db->get('course_lectures');
    	 
    	foreach ($query->result() as $data ){
    			
    		$arrTopic[$data->id]=$data->topic;
    	}
    	
    	return form_dropdown('lecture_id', $arrTopic,$value,'id="Topics"');
    }
    
    function get_topic_by_lectureid($lecture_id)
    {
    	$query = $this->db->get_where('course_lectures', array('id' => $lecture_id));
    	$result=$query->result();
    	if(!empty($result)){
    		return $result[0]->topic;
    	}
    }
    
    function get_topic_by_assignedcourseid($post_array)
    {
    	$this->db->select('id, topic');
    	$query = $this->db->get_where('course_lectures', array('assign_course_id' => $post_array['assign_course_id']));
    	$result=$query->result();
    	if(!empty($result)){
    		return json_encode($result);
    	}
    }

    function get_lecturesByFilters($post_array)
    {
        $this->db->select('id, topic');
        $query = $this->db->get_where('course_lectures', $post_array);
        $result=$query->result();
        if(!empty($result)){
            return json_encode($result);
        }
    }


    function get_all_lectures($assign_course_id , $tag=''){
        if(empty($tag))
            $query = $this->db->get_where('course_lectures', array('assign_course_id' => $assign_course_id));
        else
            $query = $this->db->get_where('course_lectures', array('assign_course_id' => $assign_course_id, 'tags'=> $tag));

        $result=$query->result();
        if(!empty($result)){
            return $result;
        }else
            return null;
    }

    function get_lecture($lecture_id)
    {
        $query = $this->db->get_where('course_lectures', array('id' => $lecture_id));
        $result=$query->result();
        if(!empty($result)){
            return $result[0];
        }
        else return null;
    }
		
}


