<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courses extends CI_Controller {

    function __construct()
    {


        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('common_helper');

        $this->load->library('grocery_CRUD');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');

        $this->load->model('Sections_Model','sections');
        $this->load->model('Years_Model','years');
        $this->load->model('Students_Model','students');
        $this->load->model('Courses_Model','courses');
        $this->load->model('Assign_Course_Model','assign_courses');
        $this->load->model('Course_Lecture_Model','course_lecture');

        if (!$this->ion_auth->logged_in())
        {
            ci_redirect('authenticate/login');
        }
    }

    function index()
    {
        $user = $this->ion_auth->user()->row();
        $student = $this->students->get_student_row_by_userid($user->id);
        $year_dropdown = $this->years->get_studentsyear_dropdown($student['year_id']);

        $studentInfo = $this->load->view('student/studentinfo', array('student'=> $student), true);
        // Pass to the master view
        $content = $this->load->view('student/course', array('year' => $year_dropdown), true);

        $data = array();
        $header = array();
        $footer = array();
        $header['user'] = $user;
        $header['student_id'] = $student['id'];

        $data['header'] = $header;
        $data['footer'] = $footer;
        $data['content'] = $content;
        $data['studentInfo'] = $studentInfo;

        $this->load->view('student/master_inner', $data);
    }

    function list_all($year,$section,$student_id){
        $courseList = $this->courses->get_all_courses($year,$section,$student_id);

        $this->load->view('student/courselist',array('list'=> $courseList));
    }

    function view(){

        $assignCourseId = $this->uri->segment(4);

        if($assignCourseId ==0){
            ci_redirect('student/courses');
        }

        //Get Assign_Course
        $assignCourse = $this->assign_courses->get_assign_course_by_id($assignCourseId);
        if($assignCourse==null){
            ci_redirect('student/courses');
        }

        // Get Course Detail
        $course = $this->courses->get_course($assignCourse->course_id);
        if($course==null){
            ci_redirect('student/courses');
        }
        // Get Assigned Teachers
        $courseAssignments = $this->assign_courses->get_course_teachers($assignCourseId);
        // Get Lectures
        $lectures = $this->course_lecture->get_all_lectures($assignCourseId);

        $user = $this->ion_auth->user()->row();
        $student = $this->students->get_student_row_by_userid($user->id);
        $studentInfo = $this->load->view('student/studentinfo', array('student'=> $student), true);
        $lectureList = $this->load->view('student/lecturelist', array('lectures' => $lectures), true);
        $content = $this->load->view('student/coursedetail', array('course' => $course, 'course_assignments'=> $courseAssignments,'lectures' => $lectures, 'lecture_list'=> $lectureList, 'course_assignment_id' => $assignCourseId), true);
        $course_teachers = $this->load->view('student/course_teachers',array('course' => $course, 'course_assignments'=> $courseAssignments),true);

        $data = array();
        $header = array();
        $footer = array();
        $header['user'] = $user;
        $header['student_id'] = $student['id'];

        $data['header'] = $header;
        $data['footer'] = $footer;
        $data['content'] = $content;
        $data['studentInfo'] = $studentInfo;        
        //$data['right'] = $course_teachers;
        $data['studentInfo'] .= $course_teachers;
        
        $this->load->view('student/master_inner', $data);
    }

    function get_lectures($tag, $assignment_course_id){
        if($tag=='all')
            $tag='';
        // Get Lectures
        $lectures = $this->course_lecture->get_all_lectures($assignment_course_id, $tag);

        $user = $this->ion_auth->user()->row();
        $this->load->view('student/lecturelist', array('lectures' => $lectures));

    }

    function lecture(){
        $lecture_id = $this->uri->segment(4);

        if($lecture_id ==0){
            ci_redirect('student/courses');
        }

        //Get Lecture
        $lecture = $this->course_lecture->get_lecture($lecture_id);
        if($lecture==null){
            ci_redirect('student/courses');
        }

        $user = $this->ion_auth->user()->row();
        $student = $this->students->get_student_row_by_userid($user->id);
        $studentInfo = $this->load->view('student/studentinfo', array('student'=> $student), true);
        $content = $this->load->view('student/lecture', array('lecture' => $lecture), true);

        $data = array();
        $header = array();
        $footer = array();
        $header['user'] = $user;
        $header['student_id'] = $student['id'];

        $data['header'] = $header;
        $data['footer'] = $footer;
        $data['content'] = $content;
        $data['studentInfo'] = $studentInfo;
        //$data['right'] = array();

        $this->load->view('student/master', $data);
    }

}
