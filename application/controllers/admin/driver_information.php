<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Driver_information extends CI_Controller {
	
	function __construct()
	{   
		
		
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('grocery_CRUD');
		$this->load->helper('common_helper');
		$this->load->library('session');
		$this->load->model('Cab_Model','cab');
		$this->load->model('Dispatcher_Model','dispatcher');
		$this->load->model('Cab_provider_Model','cab_provider');
		$this->load->model('Users_Model','users');
		$this->load->model('Driver_Model','driver');
		
		$session_data=$this->session->all_userdata(); 
		//$this->pr($session_data); die;
		if(isset($session_data['group_id']) ){
			if($session_data['group_id']==1) { 
				$this->index(); 
			} 	
			
			else{
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
		
	}

	function view()
	{		
		try{
			
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('driver_information');
			$crud->set_subject('Driver Info');
			$crud->required_fields('code','name','description','first_name','last_name');
			
			$crud->unset_print();
			$crud->unset_export();
			$crud->unset_add();
			$crud->columns('name','age','gender','contact_no','license_code','cab_id','pob_status','post_check_in','first_name','last_name');
			$crud->fields('name','age','gender','contact_no','license_code','cab_id','pob_status','post_check_in','first_name','last_name','dispatcher_id','user_id');
				
			$crud->field_type('user_id', 'hidden'); // making field hidden makes it remain in post_array
			
			/*call back for edit form->passes value attribute with items value to the function*/
			$crud->callback_edit_field('dispatcher_id',array($this->dispatcher,'get_dispatcher_dropdown'));
			$crud->callback_edit_field('cab_provider_id',array($this,'get_cab_provider_dropdown_edit'));
			$crud->callback_add_field('dispatcher_id',array($this->dispatcher,'get_dispatcher_dropdown'));
			$crud->callback_add_field('cab_provider_id',array($this,'cab_provider'));
			
			
			
			//$crud->callback_column('first_name',array($this,'get_first_name'));
			$crud->callback_edit_field('first_name',array($this,'first_name_edit'));
			$crud->callback_edit_field('last_name',array($this,'last_name_edit'));
			$crud->callback_edit_field('cab_id',array($this,'get_cab_no_by_cab_provider_id_dropdown'));
				
			
			$crud->callback_column('first_name',array($this,'get_first_name'));
			//$crud->callback_column('last_name',array($this->users,'get_last_name_by_id'));
			$crud->callback_column('cab_id',array($this->cab,'get_cab_by_id'));
			$crud->callback_column('dispatcher_id',array($this->dispatcher,'get_dispatcher_by_id'));
			
			$crud->display_as('cab_id','Cab#');
			$crud->display_as('dispatcher_id','Dispatcher');
			
			
			$crud->callback_before_update(array($this,'call_before_update'));
				
		
			$output = $crud->render();
			//$this->pr($output);


            $content = $this->load->view('admin/driver.php',$output,true);
            // Pass to the master view
            $this->load->view('admin/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
    

	function get_first_name($value,$row){
	
		$row->last_name= $this->users->get_last_name_by_id($row->user_id);
		return $this->users->get_first_name_by_id($row->user_id);
	}
	
	
	function first_name_edit($value,$id){
		
		$user_id=$this->driver->get_user_id_by_driver_id($id);
		$fname=$this->users->get_first_name_by_id($user_id);
		return "<input id='field-first_name' name='first_name' type='text' value='{$fname}'>";
	}
	
	
	function last_name_edit($value,$id){
		$user_id=$this->driver->get_user_id_by_driver_id($id);
		$lname=$this->users->get_last_name_by_id($user_id);
		return "<input id='field-last_name' name='last_name' type='text' value='{$lname}'>";
	}
	
	function cab_provider(){
	
		return 	$this->cab_provider->get_cab_provider_dropdown(null,null);
	}
	
	function get_cab_provider_dropdown_edit($value,$row){
		
		return 	$this->cab_provider->get_cab_provider_dropdown($value,null);
	}

	function call_before_update($post_array){
		$session=$this->session->all_userdata();
		if($post_array['cab_id']!=	$session['cab_id']){ // means cab  changed in edit
			//update the cab_id if already assignet to a driver because its been given to a new driver
			$this->driver->update_cab_id($post_array['cab_id']);
			
		}
		$this->session->unset_userdata('cab_id');
		//update first last name in users 
		// takes fisrt_name,last_name  and id as third param
		$this->users->update_first_last_name($post_array['first_name'],$post_array['last_name'],$post_array['user_id']); 
		
		unset($post_array['first_name']);
		unset($post_array['last_name']);
		
		return $post_array;
	}
	
	function get_cab_no_by_cab_provider_id_dropdown($value,$id){
		  //saving cab_id to check on edit whether its changed or not 
		$this->session->set_userdata('cab_id', $value);
		return $this->cab->get_cab_no_by_cab_provider_id_dropdown($value,$id);
	}
	
	function get_driver_by_cab_provider_id($cab_provider_id=''){
	
		echo $this->driver->get_driver_by_cab_provider_id($cab_provider_id);
	}
	function get_user_id_by_cab_provider_id($cab_provider_id=''){
	
		echo $this->driver->get_user_id_by_cab_provider_id($cab_provider_id);
	}
	
	
	
	
}