<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update_attendance extends CI_Controller {
	


	function __construct()
	{   
		
		
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('grocery_CRUD');
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->model('Sections_Model','sections');
		$this->load->model('Years_Model','years');
		$this->load->model('Common_Model','common');
		$this->load->model('assign_Course_Model','assign');
		$this->load->model('Teachers_Model','teachers');
		$this->load->model('Students_Model','students');
		$this->load->model('Courses_Model','courses');
		$this->load->model('Users_Model','users');
		$this->load->model('course_Content_Model','content');
		$this->load->model('course_Lecture_Model','lectures');
		$this->load->model('attendance_Model','attendance');
		$this->load->helper('common_helper');
		$this->load->library('session');
		
		
		
		if (!$this->ion_auth->logged_in())
		{
			ci_redirect('authenticate/login');
		}
		
		if (!$this->ion_auth->is_admin())
		{
			$this->session->set_flashdata('message', 'You must be an admin to view this page');
			ci_redirect('');
		}
		
	}



	function select()
	{
		$status=$this->session->flashdata('status');
		$sections=$this->sections->get_sections_dropdown(1);
		$assigned_course=$this->assign->get_assigned_course_dropdown();
		$content = $this->load->view('admin/select_update_attendance.php',	array('sections' => $sections,'assigned_course'=>$assigned_course,'status'=>$status['status']),true);
		$this->load->view('admin/master', array('content' => $content));
	}
	
	
	function index()
	{   
		$this->select();
	}



	function view()
	{		
	
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('flexigrid');
			$crud->set_table('attendance');
			$crud->set_model('students_attendance');
			$crud->set_subject('Select items');
						
			$crud->unset_add();
			$crud->unset_delete();
			
			$crud->columns('student_id','assign_course_id','is_present','date');
			$crud->callback_column('student_id',array($this->students,'get_student_by_id'));
			$crud->callback_column('assign_course_id',array($this->assign,'get_assigned_course_by_id'));
			$crud->callback_column('is_present',array($this->common,'get_attendance_status'));
			
			$crud->display_as('is_present','Status');
			$crud->display_as('student_id','Student Name');
			$crud->display_as('assign_course_id','Course');
			
		
			$crud->edit_fields('is_present');
			$output = $crud->render();
            $content = $this->load->view('admin/update_attendance.php',$output,true);
            // Pass to the master view
            $this->load->view('admin/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	

}