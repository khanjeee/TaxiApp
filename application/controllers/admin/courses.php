<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courses extends CI_Controller {

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
		$this->load->model('Years_Model','years');
		$this->load->model('Courses_Model','courses');
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
			$crud->set_table('courses');
			$crud->set_subject('Courses');
			$crud->required_fields('code','name','description');
			
			$crud->columns('code','name','department_id','description','status','section_id','year_id');
			
			/*Generating dropdwons for year section and course status*/
			$crud->callback_add_field('status',array($this,'status_dropdown'));
			$crud->callback_add_field('section_id',array($this->sections,'get_sections_dropdown'));
			$crud->callback_add_field('year_id',array($this->years,'get_years_dropdown'));
			$crud->callback_add_field('department_id',array($this->departments,'get_departments_dropdown'));
			
			
			
			/*call back for edit form->passes value attribute with items value to the function*/
			$crud->callback_edit_field('status',array($this,'status_dropdown'));
			$crud->callback_edit_field('section_id',array($this->sections,'get_sections_dropdown'));
			$crud->callback_edit_field('year_id',array($this->years,'get_years_dropdown'));
			$crud->callback_edit_field('department_id',array($this->departments,'get_departments_dropdown'));
			
			//insertion of created_by not present in form
			$crud->callback_before_insert(array($this,'call_before_insert'));

			/*callback for table view */
			$crud->callback_column('status',array($this,'_status'));
			$crud->callback_column('section_id',array($this->sections,'get_section_by_id'));
			$crud->callback_column('year_id',array($this->years,'get_year_by_id'));
			$crud->callback_column('department_id',array($this->departments,'get_department_by_id'));
		
			
			/*used to display fields when adding items*/
			$crud->fields('code','name','department_id','description','status','section_id','year_id','created_by');
			
			/*hidding a field for insertion via call_before_insert crud requires field to be present in Crud->fields*/
			$crud->change_field_type('created_by','invisible');
			
			/*used to change names of the fields*/
			$crud->display_as('description','Description');
			$crud->display_as('name','Name');
			$crud->display_as('status','Status');
			$crud->display_as('section_id','Section');
			$crud->display_as('year_id','Year');
			$crud->display_as('department_id','Department');
			
			
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

	function status_dropdown($value) {
		$value=(!empty($value))? $value : 1;
		$options = array(
				'1'  => 'Active',
				'2'    => 'Inactive',

		);
		return  form_dropdown('status', $options, $value);
	}

	function _status($value) {
		return $value=($value==1)? 'Active' : 'Inactive';
		
	}
	
	function get_courses_by_year(){
		//print_r($post_array);
		echo $this->courses->get_courses_by_year($_POST);
	}

	
	

	




}