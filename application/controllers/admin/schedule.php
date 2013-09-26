<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends CI_Controller {

	function __construct()
	{   
		
		
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('grocery_CRUD');
		$this->load->library('ion_auth');
		$this->load->model('Sections_Model','sections');
		$this->load->model('Departments_Model','departments');
		$this->load->model('assign_Course_Model','assign');
		$this->load->model('Courses_Model','courses');
		$this->load->helper('common_helper');
		
		
		
		
		if (!$this->ion_auth->logged_in())
		{
			ci_redirect('auth/login');
		}
		
		if (!$this->ion_auth->is_admin())
		{
			$this->session->set_flashdata('message', 'You must be an admin to view this page');
			ci_redirect('');
		}
		
	}




	function index()
	{
		
		//pr($query->result()); die;
		 //test_method('Hello World');
		//$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}



	function view()
	{		
		
		

		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('flexigrid');
			$crud->set_table('schedules');
			$crud->set_subject('Schedule');
			$crud->required_fields('start_on','end_on','room','day','duration');
			
			$crud->columns('assign_course_id','start_on','end_on','room','day','duration','created_by');
			
			/*Generating dropdwons for year section and course status*/
			
			$crud->callback_add_field('assign_course_id',array($this->assign,'get_assigned_course_dropdown'));
			
			/*call back for edit form->passes value attribute with items value to the function*/
			
			$crud->callback_edit_field('assign_course_id',array($this->assign,'get_assigned_course_dropdown'));
			
			//insertion of created_by not present in form
			$crud->callback_before_insert(array($this,'call_before_insert'));

			/*callback for table view */
			
			$crud->callback_column('assign_course_id',array($this->assign,'get_assigned_course_by_id'));
		
			
			/*used to display fields when adding items*/
			$crud->fields('assign_course_id','start_on','end_on','room','day','duration','created_by');
			
			/*hidding a field for insertion via call_before_insert crud requires field to be present in Crud->fields*/
			$crud->change_field_type('created_by','invisible');
			
			/*used to change names of the fields
			$crud->display_as('description','Description');
			$crud->display_as('name','Name');
			$crud->display_as('status','Status');
			$crud->display_as('section_id','Section');
			$crud->display_as('year_id','Year');
			$crud->display_as('department_id','Department');*/
			
			
			//$this->pr($crud); 
			//die;
			$output = $crud->render();
			//$this->pr($output);


            $content = $this->load->view('admin/courses.php',$output,true);
            // Pass to the master view
            $this->load->view('admin/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
    
	function call_before_insert($post_array){
		
		$user = $this->ion_auth->user()->row();
		$post_array['created_by']=$user->id;
		return $post_array;
		
	
	}



	
	

	




}