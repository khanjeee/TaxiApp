<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cabs extends CI_Controller {

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
		$this->load->model('Driver_Model','driver');
		
		
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
		$this->view();
		//pr($query->result()); die;
		 //test_method('Hello World');
		//$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	function assign()
	{
		$status=$this->session->flashdata('message');
		$drivers=$this->users->get_users_by_group_id_dropdown(6); //getting drivers
		$cabs=$this->driver->get_cabs_not_in_driver_information_dropdown();
		$cab_provider=$this->cab_provider();
	
		$content = $this->load->view('admin/assign_cab.php',	array('cab_provider'=>$cab_provider,'drivers' => $drivers,'cabs' => $cabs,'status'=>$status),true);
		$this->load->view('admin/master', array('content' => $content));
	}
	
	function insert_assigned(){
		if(isset($_POST) && !empty($_POST['user_id']) && !empty($_POST['cab_id'])){
			
			$this->db->insert('driver_to_cabs', array('cab_id' => $_POST['cab_id'] ,'driver_id' => $_POST['user_id']));
			
			$this->db->where('id', $_POST['cab_id']);
			$this->db->update('cabs', array('driver_assigned' => 'yes'));
			
			$this->session->set_flashdata('message', 'Cab successfully assigned to driver.');
			ci_redirect('admin/cabs/assign','refresh');
		
		}
		
	}

	function view()
	{		
		
		

		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('cabs');
			$crud->set_subject('Cab');
			$crud->required_fields('cab_provider_id','cab_no','cab_available','driver_assigned','status');
			
			$crud->columns('cab_provider_id','cab_no','color','model','make','cab_available','driver_assigned','status','driver_name');
			$crud->fields('cab_provider_id','cab_no','color','model','make','cab_available','driver_assigned','status');
			$crud->edit_fields('cab_provider_id','cab_no','color','model','make','cab_available','driver_assigned','status','driver_name');
			//$crud->set_field_upload('image_url',UPLOAD_CAB_IMAGE);
			
			$crud->unset_print();
			$crud->unset_export();
			
			$crud->callback_add_field('cab_provider_id',array($this,'cab_provider'));
			$crud->callback_edit_field('cab_provider_id',array($this->cab_provider,'get_cab_provider_dropdown'));
			$crud->callback_column('cab_provider_id',array($this->cab_provider,'get_cab_provider_by_id'));
			$crud->callback_edit_field('cab_provider_id',array($this,'get_cab_provider_dropdown_edit'));
			
			
			$crud->callback_column('driver_name',array($this,'get_driver_name'));
			$crud->callback_edit_field('driver_name',array($this,'driver_name_edit'));
			
				
		//	$crud->callback_before_insert(array($this,'call_before_insert'));
			$crud->callback_before_update(array($this,'call_before_update'));

			
			$crud->display_as('cab_provider_id','Cab Provider');
			$crud->display_as('image_url','Cab Image');
			
			$output = $crud->render();
			//$this->pr($output);


            $content = $this->load->view('admin/cab.php',$output,true);
            // Pass to the master view
            $this->load->view('admin/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
    
	function call_before_insert($post_array){
		
		return $post_array;
	
	}
	function call_before_update($post_array,$row_id){
		//$this->pr($post_array); die;
	//	updatind driver in driver information 
	//do this operation only if driver_name is present because it is not present in case where driver is not assigned to cab
	
	if(isset($post_array['driver_name'])){  
		
		//first param is the value to be updated and second is the id of the field to be updated
		$this->driver->update_driver_name($post_array['driver_name'],$row_id); 
		//un setting to avoid grocery crud errors
		unset($post_array['driver_name']); 
	}
		return $post_array;
	
	}
	
	function cab_provider(){
		
	return 	$this->cab_provider->get_cab_provider_dropdown(null,null);
	}
	
	function get_cab_provider_dropdown_edit($value,$row){
	
		return 	$this->cab_provider->get_cab_provider_dropdown($value,null);
	}
	
	function get_cabs_by_driver_id($driver_id=''){
	
		echo $this->cab_provider->get_cabs_by_driver_id($driver_id);
	}
	
	function get_cabs_not_in_driver_information($cab_provider_id=''){
	
		echo $this->driver->get_cabs_not_in_driver_information($cab_provider_id);
	}
	
	function get_driver_name($value,$row){//if checked checkbox is posted else hidden field
		
		return $this->driver->get_driver_name_by_cab_id($row->id);
		
	}
	
	function driver_name_edit($value,$cab_id){
		
		$driver_name=$this->driver->get_driver_name_by_cab_id($cab_id);
		if(!empty($driver_name)){
		
		return "<input id='field-driver_name' name='driver_name' type='text' value='{$driver_name}'>";
		}
		
		}
	

}