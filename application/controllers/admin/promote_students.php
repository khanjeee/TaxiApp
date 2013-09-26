<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Promote_students extends CI_Controller {
	
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
		$this->load->helper('common_helper');
		
		
		
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

	function update()
	{
		$arr=array();
	
	try{
		//$this->pr($_POST);
			if(isset($_POST['year_id']) && isset( $_POST) && !empty($_POST['year_id']) ){
				$year_id=(int)$_POST['year_id'];
				unset($_POST['year_id']);
				unset($_POST['search_text']);
				unset($_POST['search_field']);
				unset($_POST['per_page']);
				unset($_POST['order_by']);
				unset($_POST['page']);
					
				if(!empty($_POST)){
				foreach ($_POST as $key=>$data){
					$arr_inner=array();
					$arr_inner['id']=$key;
					$arr_inner['year_id']=$year_id+1;
					$arr[]=$arr_inner;
		
				}
					
				$this->db->update_batch('user_student', $arr , 'id');
				}	
				ci_redirect("admin/promote_students/view/{$year_id}");
			}
			else{
				ci_redirect("admin/promote_students/view");
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
		$sections=$this->sections->get_sections_dropdown(1);
		$years= $this->years->get_years_dropdown(1);
		$batch=$this->common->get_batch_years_dropdown(2013);
		
		
		
		$content = $this->load->view('admin/select_students.php',
				array('sections' => $sections,'batch' => $batch,'years'=>$years),true);
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
			$crud->set_subject('Select Students to Promote');
			
			$crud->unset_add();
			//$crud->unset_print();
			//$crud->unset_export();
			$crud->unset_delete();
			$crud->unset_edit();
			
			//$crud->unset_jquery();
			//$crud->unset_jquery_ui();
			//$crud->unset_columns();
			
			
			
			if(intval($this->uri->segment(4))) {	//returns students by year if 4th segment exist			
			$crud->where('year_id =', intval($this->uri->segment(4)));
			$crud->where('batch_year =', $this->uri->segment(5));
			$crud->where('section_id =', $this->uri->segment(6));
			
			}
			else{
				$crud->where('year_id =',0); //hide all students if not id passed
			}
			
			$crud->columns('student_id','name','year_id','is_promoted');
			$crud->callback_column('year_id',array($this->years,'get_year_by_id'));
			$crud->callback_column('is_promoted',array($this,'create_checkbox'));
		//	$crud->callback_column('id',array($this,'populate_array'));
				
			$output = $crud->render();
			//$this->pr($output);
			

            $content = $this->load->view('admin/promote_students.php',$output,true);
            // Pass to the master view
            $this->load->view('admin/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
    
	function create_checkbox($value,$id){
		
		return "<input type='checkbox' class='checked' name='$id->id' />";
	
	}
	
	

}