<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	var $user_data;
	
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
		$this->load->model('Cab_provider_Model','cab_provider');
		$this->load->model('Department_Model','department');
		$this->load->model('Driver_Model','driver');
		$this->load->model('Journey_type_Model','journey_type');
		
		
		
		$this->load->library('session');		
		$this->user_data=$this->session->all_userdata();
		if(isset($this->user_data['group_id']) ){
			if($this->user_data['group_id']!=7) {
				$this->session->set_flashdata('message', 'You must be an admin to view this page');
				ci_redirect('admin/login','refresh');
			}
		
				
		
		}
		else{
			$this->session->set_flashdata('message', 'You must login to view this page');
			ci_redirect('admin/login','refresh');
		
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
			$session_data=$this->session->all_userdata();
			$crud->set_theme('datatables');
			$crud->set_table('users');
			$crud->where('corporate_id',$session_data['corporate_id']);
			$crud->set_subject('Users Info');
			$crud->required_fields('first_name','last_name','username','gender','phone','status','password');
			
			$crud->columns('first_name','last_name','username','gender','phone','user_image','group_id','status');
			$crud->fields('first_name','last_name','username','gender','phone','user_image','group_id','status','password','corporate_id','department_id','employee_id');
			//$crud->edit_fields('first_name','last_name','username','gender','phone','user_image','group_id','status','password');
			$crud->set_field_upload('user_image',UPLOAD_USER_IMAGE);
			$crud->field_type('password', 'password');
			$crud->field_type('corporate_id', 'hidden');
			$crud->field_type('group_id', 'hidden');
			
			$crud->unset_print();
			$crud->unset_export();
			$crud->set_rules('username', 'Username', 'callback_check_duplicate');
				
			/*@todo check username for duplicates and fix lisence no on update*/
			
			$crud->callback_column('group_id',array($this->groups,'get_group_by_id'));
			$crud->callback_edit_field('password',array($this,'save_password_copy'));
					
			$crud->callback_field('cab_provider',array($this,'get_cab_provider_dropdown')); //dummy @kmdc
			$crud->callback_field('department_id',array($this->department,'get_department_dropdown'));
			
			//insertion of created_by not present in form
			$crud->callback_before_insert(array($this,'call_before_insert'));
			$crud->callback_after_insert(array($this,'call_after_insert'));
			$crud->callback_before_update(array($this,'call_before_update'));

			$crud->display_as('department_id','Department');
			
			$output = $crud->render();
			//$this->pr($output);

            $content = $this->load->view('corporate/users.php',$output,true);
            // Pass to the master view
            $this->load->view('corporate/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
    
	function call_before_insert($post_array){
		//$this->pr($post_array); die;
		
		//making md5 with salt before insertion
		$post_array['password']=md5(SALT.$post_array['password']);
		//check group id if corporate not selected set corporate id 0
		$post_array['corporate_id']=$this->user_data['corporate_id'];
		$post_array['department_id']=($this->user_data['group_id']!=5)? 0 : $post_array['department_id']; 
		$post_array['group_id']=5;
		return $post_array;
		
	
	}
	
	function call_after_insert($post_array,$primary_key){
	
		
		return $post_array;
	
	
	}
	
	function call_before_update($post_array){
	//making md5 only if the password is changed
	$post_array['password']=($post_array['password']==$post_array['password_copy'])? $post_array['password']  : md5(SALT.$post_array['password']);	
	return $post_array;
		
	}
	 function save_password_copy($value, $row){
	
	 	return "<input type='password' maxlength='255' value={$value} name='password' id='field-password'><input type='hidden' name='password_copy' value={$value}>";
	}
	
	
	
	function get_corporate_users($value='') {
		//header('Content-Type: application/x-json; charset=utf-8');
		echo $this->users->get_corporate_users($value);
	
	}
	
	function check_duplicate($value,$row)
	{
		$row_id=$this->uri->segment(5);
		//checks for duplicate entries in db return 1 if exist else 0
		if($this->users->check_duplicate($value,$row_id)==1){
			//dont validate on edit
			$this->form_validation->set_message('check_duplicate',"Username {$value} already exist");
			return false;
		}
		else{
			return true;
		}
	
	
			
	}
	
	function get_cab_provider_dropdown()
	{
		$user_id=$this->uri->segment(5);
		$cab_provider_id=$this->driver->get_cab_provider_by_user_id($user_id);
		return $this->cab_provider->get_cab_provider_dropdown($cab_provider_id,null);
	}
	
	
	function get_journey_types_by_corporate_json($corporate_id)
	{
		echo $this->journey_type->get_journey_types_by_corporate_json($corporate_id);
	}
	
	

	
	

	




}