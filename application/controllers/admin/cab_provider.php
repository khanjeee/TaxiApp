<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cab_provider extends CI_Controller {

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
		$this->load->model('Dispatcher_Model','dispatcher');
		
		
		$this->load->library('session');		
		$session_data=$this->session->all_userdata();
		if(isset($session_data['group_id']) ){
			if($session_data['group_id']!=1) {
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

			$crud->set_theme('datatables');
			$crud->set_table('cab_provider');
			$crud->set_subject('Cab Providers');
			$crud->required_fields('name','price','description','seats_avalaible','child_seats_available','luggage_capacity','dispatcher_id','image_url','is_corporate');
			
			$crud->columns('name','price','description','seats_avalaible','child_seats_available','luggage_capacity','dispatcher_id','image_url','is_corporate');
			$crud->fields('name','price','description','seats_avalaible','child_seats_available','luggage_capacity','dispatcher_id','image_url','is_corporate');
			//$crud->edit_fields('first_name','last_name','username','gender','phone','user_image','group_id','status','password');
			$crud->set_field_upload('image_url',UPLOAD_CAB_PROVIDER_IMAGE);
			
			$crud->unset_print();
			$crud->unset_export();
			
			$crud->callback_add_field('dispatcher_id',array($this->dispatcher,'get_dispatcher_dropdown'));
			$crud->callback_edit_field('dispatcher_id',array($this->dispatcher,'get_dispatcher_dropdown'));
			$crud->callback_column('dispatcher_id',array($this->dispatcher,'get_dispatcher_by_id'));
			$crud->set_rules('child_seats_available','child seats available','required|numeric');
			$crud->set_rules('seats_avalaible','seats available','required|numeric');
			$crud->set_rules('luggage_capacity','luggage capacity','required|numeric');
			$crud->set_rules('price','price','required|numeric');
				
			//insertion of created_by not present in form
		//	$crud->callback_before_insert(array($this,'call_before_insert'));
		//	$crud->callback_before_update(array($this,'call_before_update'));

			
			$crud->display_as('dispatcher_id','Dispatcher');
			$crud->display_as('image_url','Dispatcher Image');
			
			$output = $crud->render();
			//$this->pr($output);


            $content = $this->load->view('admin/cab_provider.php',$output,true);
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
		$post_array['department_id']=($post_array['group_id']!=5)? 0 : $post_array['department_id'];
		return $post_array;
		
	
	}
	function call_before_update($post_array){
	//making md5 only if the password is changed
	$post_array['password']=($post_array['password']==$post_array['password_copy'])? $post_array['password']  : md5(SALT.$post_array['password']);	
	//print_r($post_array['password']); die;
	return $post_array;
		
	
	
	}
	

}