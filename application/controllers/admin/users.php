<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct()
	{   
		
		
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('grocery_CRUD');
		$this->load->helper('common_helper');
		$this->load->model('Groups_Model','groups');
		$this->load->model('Corporate_Model','corporate');
		$this->load->model('Users_Model','users');
		
		
		
		
		
		
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
			$crud->set_table('users');
			$crud->set_subject('Users Info');
			//$crud->required_fields('code','name','description');
			
			$crud->columns('first_name','last_name','username','gender','phone','user_image','user_id','group_id','status');
			$crud->fields('first_name','last_name','username','gender','phone','user_image','group_id','status','password','corporate_id');
			//$crud->edit_fields('first_name','last_name','username','gender','phone','user_image','group_id','status','password');
			$crud->set_field_upload('user_image',UPLOAD_USER_IMAGE);
			$crud->field_type('password', 'password');
			
			/*Generating dropdwons for year section and course status
			$crud->callback_add_field('status',array($this,'status_dropdown'));
			$crud->callback_add_field('section_id',array($this->sections,'get_sections_dropdown'));
			$crud->callback_add_field('year_id',array($this->years,'get_years_dropdown'));
			
			*/
			$crud->callback_add_field('group_id',array($this->groups,'get_groups_dropdown'));
			$crud->callback_add_field('corporate_id',array($this->corporate,'get_corporate_dropdown'));
			$crud->callback_edit_field('corporate_id',array($this->corporate,'get_corporate_dropdown'));
			$crud->callback_edit_field('group_id',array($this->groups,'get_groups_dropdown'));
			$crud->callback_edit_field('password',array($this,'save_password_copy'));
			
			
			/*call back for edit form->passes value attribute with items value to the function
			$crud->callback_edit_field('status',array($this,'status_dropdown'));
			$crud->callback_edit_field('section_id',array($this->sections,'get_sections_dropdown'));
			$crud->callback_edit_field('year_id',array($this->years,'get_years_dropdown'));
			$crud->callback_edit_field('department_id',array($this->departments,'get_departments_dropdown'));
			*/
			//insertion of created_by not present in form
			$crud->callback_before_insert(array($this,'call_before_insert'));
			$crud->callback_before_update(array($this,'call_before_update'));

			/*callback for table view 
			$crud->callback_column('status',array($this,'_status'));
			$crud->callback_column('section_id',array($this->sections,'get_section_by_id'));
			$crud->callback_column('year_id',array($this->years,'get_year_by_id'));
			$crud->callback_column('department_id',array($this->departments,'get_department_by_id'));
		*/
			
			/*used to display fields when adding items*/
			//$crud->fields('code','name','department_id','description','status','section_id','year_id','created_by');
			/*hidding a field for insertion via call_before_insert crud requires field to be present in Crud->fields*/
		//	$crud->change_field_type('created_by','invisible');
			
			/*used to change names of the fields
			$crud->display_as('description','Description');
			$crud->display_as('name','Name');
			$crud->display_as('status','Status');
			$crud->display_as('section_id','Section');
			$crud->display_as('year_id','Year');
			$crud->display_as('department_id','Department');
			
			*/
			//$this->pr($crud); 
			//die;
			$output = $crud->render();
			//$this->pr($output);


            $content = $this->load->view('admin/users.php',$output,true);
            // Pass to the master view
            $this->load->view('admin/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
    
	function call_before_insert($post_array){
		
		//making md5 with salt before insertion
		$post_array['password']=md5(SALT.$post_array['password']);
		//check group id if corporate not selected set corporate id 0
		$post_array['corporate_id']=($post_array['group_id']!=5)? 0 : $post_array['corporate_id'];
		return $post_array;
		
	
	}
	function call_before_update($post_array){
	//making md5 only if the password is changed
	$post_array['password']=($post_array['password']==$post_array['password_copy'])? $post_array['password']  : md5(SALT.$post_array['password']);	
	//print_r($post_array['password']); die;
	return $post_array;
		
	
	
	}
	 function save_password_copy($value, $row){
	
	 	return "<input type='password' maxlength='255' value={$value} name='password' id='field-password'><input type='hidden' name='password_copy' value={$value}>";
		
	
	
	}
	
	function get_corporate_users($value='') {
		//header('Content-Type: application/x-json; charset=utf-8');
		echo $this->users->get_corporate_users($value);
	
	
	
	}

	

	
	
	

	
	

	




}