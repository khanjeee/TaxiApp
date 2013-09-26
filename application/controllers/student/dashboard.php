<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{   
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('grocery_CRUD');
		$this->load->library('ion_auth');
		//$this->load->library('Phpbb_bridge');
        $this->load->helper('common_helper');
        $this->load->model('Sections_Model','sections');
		$this->load->model('Years_Model','years');
        $this->load->model('Students_Model','students');
        $this->load->model('Groups_Model','groups');
        $this->load->model('Schedules_Model','schedules');
        $this->load->model('Courses_Model','courses');
        $this->load->model('Assign_Course_Model','assign_courses');
        $this->load->model('Notification_Board_Model','notifications');
        $this->load->model('Student_Assestments_Model', 'student_assestments');
        $this->load->model('Common_Model','common');

        if (!$this->ion_auth->logged_in())
		{
			ci_redirect('authenticate/login');
		}
	}

	function index()
	{
		$user = $this->ion_auth->user()->row();

        $student =  $this->students->get_student_row_by_userid($user->id);
        $courseList = $this->courses->get_all_courses($student['year_id'],$student['section_id'],$student['id']);

        $last5Assessments = $this->student_assestments->get_last5_assessments_by_student_id($student['id']);

        $studentInfo = $this->load->view('student/studentinfo', array('student'=> $student), true);
        $schedule = $this->load->view('student/dashboard_schedule',array(),true);
        $course = $this->load->view('student/dashboard_course',array('courses' => $courseList),true);
        $right = $this->load->view('student/dashboard_right',array('last5assessments'=> $last5Assessments),true);

        $notifications = $this->notifications->get_notifications($student['section_id'],$student['year_id'],10);
        $content = $this->load->view('student/dashboard',array('schedule' => $schedule, 'course'=>$course, 'notifications' => $notifications),true);

        $data = array();
        $header = array();
        $footer = array();
        $header['user'] = $user;
        $header['student_id'] = $student['id'];

        $data['header'] = $header; 
        $data['footer'] = $footer;
        $data['content'] = $content;
        $data['studentInfo'] = $studentInfo;
        $data['right'] = $right;
        // Pass to the master view
        $this->load->view('student/master', $data);
	}


    function schedule(){
        $user = $this->ion_auth->user()->row();

        $student = $this->students->get_student_row_by_userid($user->id);
        $studentInfo = $this->load->view('student/studentinfo', array('student'=> $student), true);
        // Pass to the master view
        $content = $this->load->view('student/schedule', array(),true);
        
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

    function get_schedule(){

        $start = date("Y-m-d 00:00:00",$_GET['start']);
        $end = date("Y-m-d 23:59:59",$_GET['end']);
        $batch_year = trim($_GET['batch_year']);
        $year = trim($_GET['year_id']);

        $timeStamp = strtotime($start);

        $actualYear= (int) $batch_year + (int) $year -1;

        //$result = $this->schedules->get_schedules($start,$end);
        $result = $this->schedules->get_schedulesByYear($actualYear);

        $returnArr = array();
        foreach($result  as $item){
            switch(strtolower($item['day'])){
                case 'sunday':{
                    $dayDate = mktime(0, 0, 0, date("m",$timeStamp)  , date("d",$timeStamp), date("Y",$timeStamp));
                    break;
                }
                case 'monday':{
                    $dayDate = mktime(0, 0, 0, date("m",$timeStamp)  , date("d",$timeStamp)+1, date("Y",$timeStamp));
                    break;
                }
                case 'tuesday':{
                    $dayDate = mktime(0, 0, 0, date("m",$timeStamp)  , date("d",$timeStamp)+2, date("Y",$timeStamp));
                    break;
                }
                case 'wednesday':{
                    $dayDate = mktime(0, 0, 0, date("m",$timeStamp)  , date("d",$timeStamp)+3, date("Y",$timeStamp));
                    break;
                }
                case 'thursday':{
                    $dayDate = mktime(0, 0, 0, date("m",$timeStamp)  , date("d",$timeStamp)+4, date("Y",$timeStamp));
                    break;
                }
                case 'friday':{
                    $dayDate = mktime(0, 0, 0, date("m",$timeStamp)  , date("d",$timeStamp)+5, date("Y",$timeStamp));
                    break;
                }
                case 'saturday':{
                    $dayDate = mktime(0, 0, 0, date("m",$timeStamp)  , date("d",$timeStamp)+6, date("Y",$timeStamp));
                    break;
                }
            }

            $km = array(
                'id' => $item['id'],
                'title' => $item['code']."\n". $item['course_name'],
                'start' => date('Y-m-d H:i:s', strtotime(date('Y-m-d', $dayDate).' '. date('H:i:s', strtotime($item['start_on'])))),
                'end'   => date('Y-m-d H:i:s', strtotime(date('Y-m-d', $dayDate).' '. date('H:i:s', strtotime($item['end_on'])))),
                'allDay' => false
            );

            $returnArr[] = $km;
        }

        echo json_encode($returnArr);
    }

    function noticeboard(){
        $user = $this->ion_auth->user()->row();
        $student = $this->students->get_student_row_by_userid($user->id);
        $studentInfo = $this->load->view('student/studentinfo', array('student'=> $student), true);

        $notifications = $this->notifications->get_notifications($student['section_id'],$student['year_id']);

        $content = $this->load->view('student/noticeboard',array('notifications'=>$notifications),true);
        
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

    function profile(){

        $user_id = $this->uri->segment(5);
        $user = $this->ion_auth->user()->row();
        $student = $this->students->get_student_row_by_userid($user->id);

        if($student['id'] != $user_id){
            ci_redirect('student/dashboard');
        }

        try{

            $crud = new grocery_CRUD();

            $crud->set_theme('flexigrid');
            $crud->set_table('user_student');
            $crud->set_subject('Update Profile');
            $crud->unset_add();
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_delete();
            $crud->unset_back_to_list();
            $crud->unset_list();

            $crud->required_fields('student_id','name','email','father_name','address','religion','phone','gender','role_number','dob','phone_home','phone_father');

            $crud->columns('student_id','name','email','father_name','address','religion','phone','role_number');

            /*used to display fields when adding items*/
            $crud->fields('user_id','name','student_id','forum_id','email','father_name','address','religion','gender','dob','phone','phone_home','phone_father','role_number');

            /*hidding a field for insertion via call_before_insert crud requires field to be present in Crud->fields*/
            $crud->change_field_type('user_id','invisible');
            $crud->change_field_type('forum_id','invisible');

            /*hidding a field for insertion via call_before_insert crud requires field to be present in Crud->fields*/
            //$crud->change_field_type('created_by','invisible');

            /*used to change names of the fields*/
            $crud->display_as('student_id','Student Id');
            $crud->display_as('name','Name');
            $crud->display_as('email','Email');
            $crud->display_as('father_name','Fathers Name');
            $crud->display_as('address','Address');
            $crud->display_as('religion','Religion');
            $crud->display_as('role_number','Roll #');
//            $crud->display_as('batch_year','Batch');
//            $crud->display_as('section_id','Section');
//            $crud->display_as('year_id','Year');


            /*call back for edit form->passes value attribute with items value to the function*/
            //$crud->callback_edit_field('section_id',array($this->sections,'get_sections_dropdown'));
            //$crud->callback_edit_field('year_id',array($this->years,'get_years_dropdown'));
            //$crud->callback_edit_field('batch_year',array($this->common,'get_batch_years_dropdown'));

            $output = $crud->render();
            //$this->pr($output);

            $content = $this->load->view('student/profile.php',$output,true);
            // Pass to the master view
            //$this->load->view('admin/master', array('content' => $content));

            $studentInfo = $this->load->view('student/studentinfo', array('student'=> $student), true);

            $data = array();
            $header = array();
            $footer = array();
            $header['user'] = $user;
            $header['student_id'] = $student['id'];

            $data['header'] = $header;
            $data['footer'] = $footer;
            $data['content'] = $content;
            $data['studentInfo'] = $studentInfo;

//            $crud->callback_after_update(array($this,'call_after_update'));

            $this->load->view('student/master_inner', $data);


        }catch(Exception $e){
            show_error($e->getMessage().' --- '.$e->getTraceAsString());

        }

    }

//    function call_after_update(){
//        echo 'here';
//        ci_redirect('student/dashboard');
//    }


}
