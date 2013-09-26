<?php

class Student_Assestments_Model  extends CI_Model  {


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('form');
    }

//    function user_attempt($student_id, $lecture_id){
//
//        $query = $this->db->get_where('student_assestments', array('student_id' => $student_id, 'lecture_id'=> $lecture_id));
//        $result=$query->result();
//        if(!empty($result)){
//            return true;
//        }else{
//            return false;
//        }
//    }

    function insert($student_id, $lecture_id, $score){
        $data = array(
            'lecture_id' => $lecture_id,
            'student_id' => $student_id,
            'score'      => $score
        );

        return $this->db->insert('student_assestments', $data);
    }


    function get_assessments_by_lecture_id($lecture_id){

        $query = $this->db->get_where('student_assestments', array('lecture_id' => $lecture_id));
        $result=$query->result_array();

        //$result=$query->result_array();
        return $result;

    }

    function get_last5_assessments_by_student_id($student_id){

        $query = $this->db->query('SELECT sa.*,cl.topic , c.code,c.name
                                    FROM student_assestments as sa
                                    INNER JOIN course_lectures as cl on cl.id = sa.lecture_id
                                    INNER JOIN assign_course as ac on ac.id = cl.assign_course_id
                                    INNER JOIN courses as c on c.id = ac.course_id
                                    WHERE student_id = ?
                                    ORDER BY sa.id DESC
                                    LIMIT 5;
                                    ', array($student_id));

        $result=$query->result_array();
        return $result;

    }
}


