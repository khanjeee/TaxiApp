<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendance extends CI_Controller {
	
	public   $promoted_students=array();

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

	function insert()
	{
		
		$arr=array();
	
	try{
		
			if(isset($_POST['assign_course_id'])){
				$assign_course_id=(int)$_POST['assign_course_id'];
				$date=$_POST['date'];
				unset($_POST['year_id']);
				unset($_POST['search_text']);
				unset($_POST['search_field']);
				unset($_POST['per_page']);
				unset($_POST['order_by']);
				unset($_POST['page']);
				unset($_POST['assign_course_id']);
				unset($_POST['date']);
					
				//$this->pr($_POST);die;
				if(!empty($_POST)){
				foreach ($_POST as $key=>$data){
					$arr_inner=array();
					$arr_inner['student_id']=$key;
					$arr_inner['assign_course_id']=$assign_course_id;
					$arr_inner['is_present']=(int)$data;
					$arr_inner['date']=$date;
					$arr[]=$arr_inner;
		
				}
					
				$this->db->insert_batch('attendance', $arr);
				//echo'attendance marked successfully';
				$status = array('status'  => 'attendance successfully marked');
				$this->session->set_flashdata('status', $status);
				ci_redirect("admin/attendance");
				
				}
				else{
					$status = array('status'  => 'Nothing selected');
					$this->session->set_flashdata('status', $status);
					ci_redirect("admin/attendance");
				}	
				//ci_redirect("admin/attendance");
			}
			else{
				$status = array('status'  => 'attendance could not be  marked');
				$this->session->set_flashdata('status', $status);
				ci_redirect("admin/attendance");
			
			}
	}
	catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
		//$this->pr($_POST);
	
	
	
		//$this->pr($arr);
	
		//test_method('Hello World');
		//$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	function select()
	{
		$status=$this->session->flashdata('status');
		
		//die;
		$sections=$this->sections->get_sections_dropdown(1);
		//$years= $this->years->get_years_dropdown(1);
		$batch=$this->common->get_batch_years_dropdown(2013);
		$assigned_course=$this->assign->get_assigned_course_dropdown();
		
		
		$calendar=date("Y-m-d",time());
		
		
		$content = $this->load->view('admin/select_attendance.php',
				array('sections' => $sections,'batch' => $batch,'assigned_course'=>$assigned_course,'calendar'=>$calendar,'status'=>$status['status']),true);
		// Pass to the master view
		$this->load->view('admin/master', array('content' => $content));
	}
	
	
	function index()
	{   /* $yearaa=1;
		$year="admin/promote_students/view/{$yearaa}";
		ci_redirect($year); */
		$this->select();
	}



	function view()
	{		
	
		

		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('flexigrid');
			$crud->set_table('user_student');
			$crud->set_subject('Select Students Present');
			 $crud->set_model('students_course');			
			$crud->unset_add();
			//$crud->unset_print();
			//$crud->unset_export();
			$crud->unset_delete();
			$crud->unset_edit();
			
			//$crud->unset_jquery();
			//$crud->unset_jquery_ui();
			//$crud->unset_columns();
			
			
			
			/* if(intval($this->uri->segment(4))) {	//returns students by year if 4th segment exist			
		//	$crud->where('assign_course_id =', intval($this->uri->segment(4)));
			$crud->where('batch_year =', $this->uri->segment(5));
			$crud->where('section_id =', $this->uri->segment(6));
			
			}
			else{
				$crud->where('year_id =',0); //hide all students if not id passed
			} */
			
			$crud->columns('student_id','name','year_id','is_present');
			$crud->callback_column('year_id',array($this->years,'get_year_by_id'));
			$crud->callback_column('is_present',array($this,'create_checkbox'));
		//	$crud->callback_column('id',array($this,'populate_array'));
				
			$output = $crud->render();
			
			

            $content = $this->load->view('admin/insert_marked_attendance.php',$output,true);
            // Pass to the master view
            $this->load->view('admin/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	function check_attendance(){
		
		echo $this->attendance->check_attendance($_POST);
	}
    
	function create_checkbox($value,$id){//if checked checkbox is posted else hidden field
		
		return "<input type='hidden' value='0' name='$id->id'><input type='checkbox' class='checked' name='$id->id' value='1' />";
	
	}
	
	

}