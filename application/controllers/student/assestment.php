<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assestment extends CI_Controller {

    function __construct()
    {

        session_start();
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('grocery_CRUD');
        $this->load->library('ion_auth');
        $this->load->model('course_Lecture_Model','lectures');
        $this->load->model('Years_Model','years');
        $this->load->model('Courses_Model','courses');
        $this->load->model('Users_Model','users');
        $this->load->model('Common_Model','common');
        $this->load->model('Answers_Model','answers');
        $this->load->model('Questions_Model','questions');
        $this->load->model('Assign_Course_Model','assign_course');
        $this->load->model('Students_Model','students');
        $this->load->model('Student_Assestments_Model', 'student_assestments');
        $this->load->model('course_Lecture_Model', 'course_lecture');

        if (!$this->ion_auth->logged_in())
        {
            ci_redirect('authenticate/login');
        }

    }

    function index()
    {
        ci_redirect('student/courses');
    }

    function getQuestion($questions, $question_id){
        foreach($questions as $question){
            if($question->id == $question_id)
                return $question;
        }
    }

    function view(){

        try{

            $lecture_id = $this->uri->segment(4);

            if($lecture_id ==0){
                ci_redirect('student/courses');
            }
            $user = $this->ion_auth->user()->row();
            $student = $this->students->get_student_row_by_userid($user->id);
            $answers = $this->answers->get_answers_by_lecture($lecture_id);
            $studentInfo = $this->load->view('student/studentinfo', array('student'=> $student), true);
            $questions = $this->questions->get_questions($lecture_id);

            if(isset($_POST['question'])){
                $score = 0;
                $num_of_qts = 0;
                $assestment = $_POST['question'];
                foreach($assestment as $key => $value){
                    $num_of_qts ++;
                    $question = $this->getQuestion($questions,$key);  //$this->questions->get_question($key);
                    foreach($answers as $answer){
                        if($key == $answer['question_id']){
                            if($question->type == 'MCQ'){
                                if($value['answer'] == $answer['id']){
                                    if($answer['is_correct']==1){
                                        $value['result'] = true;
                                        $score++;
                                        break;
                                    }else{
                                        $value['result'] = false;
                                    }
                                }
                            }else {
                                if($value['answer']== $answer['id']){
                                    $value['result'] = true;
                                    $score++;
                                    break;
                                }else{
                                    $value['result'] = false;
                                    break;
                                }
                            }
                        }
                    }
                    $assestment[$key] = $value;
                }

                if($this->student_assestments->insert($student['id'], $lecture_id, $score)){
                   // $_SESSION['result'. $student['id']] = array('message'=> "success", 'score' => $score, 'num_of_questions' => $num_of_qts);
                    //$content = $this->load->view('student/result', array('result'=> $_SESSION['result'. $student['id']]), true);
                    //unset($_SESSION['result'. $student['id']]);
                    $content = $this->load->view('student/result', array('message'=> "success", 'score' => $score, 'num_of_questions' => $num_of_qts , 'questions'=> $questions, 'answers' => $answers , 'assestment' => $assestment), true);

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

            }else{

//            $studentInfo = $this->load->view('student/studentinfo', array('student'=> $student), true);
//            $questions = $this->questions->get_questions($lecture_id);
            $content = $this->load->view('student/assessment', array('questions'=> $questions, 'answers' => $answers), true);

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

            //    $this->load->view('student/master', $data);

        }


        }catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    function result(){


        $user = $this->ion_auth->user()->row();
        $student = $this->students->get_student_row_by_userid($user->id);

        if(!isset($_SESSION['result'. $student['id']])){
            ci_redirect('student/courses');
        }

        $studentInfo = $this->load->view('student/studentinfo', array('student'=> $student), true);

        $content = $this->load->view('student/result', array('result'=> $_SESSION['result'. $student['id']]), true);
        unset($_SESSION['result'. $student['id']]);

        $data = array();
        $header = array();
        $footer = array();
        $header['user'] = $user;
        $header['student_id'] = $student['id'];

        $data['header'] = $header;
        $data['footer'] = $footer;

        $data['content'] = $content;
        $data['studentInfo'] = $studentInfo;

        $this->load->view('student/master', $data);
    }

    function history(){

        $user = $this->ion_auth->user()->row();
        $student = $this->students->get_student_row_by_userid($user->id);
        $studentInfo = $this->load->view('student/studentinfo', array('student'=> $student), true);

        $courseDDL = $this->assign_course->get_assigned_course_dropdownByYearSection($student['year_id'],$student['section_id']);
        $content = $this->load->view('student/assessment_history',array('courses'=> $courseDDL), true);

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

    function get_lectures($assignment_course_id){
        // Get Lectures
        $lectures = $this->course_lecture->get_lecturesByFilters(array('assign_course_id'=>$assignment_course_id, 'publish_assestment' => 1, 'is_assignment'=> 0));
        echo $lectures;
    }

    function get_history($lecture_id){
        // Get Assessments
        $list = $this->student_assestments->get_assessments_by_lecture_id($lecture_id);

        $this->load->view('student/assessmentlist', array('list' => $list));

    }

}
?>