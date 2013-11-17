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
			$crud->required_fields('code','name','description');
			
			$crud->unset_print();
			$crud->unset_export();
			$crud->columns('name','age','gender','contact_no','license_code','cab_id','user_id','pob_status','post_check_in','dispatcher_id');
			
			/*call back for edit form->passes value attribute with items value to the function*/
			$crud->callback_edit_field('dispatcher_id',array($this->dispatcher,'get_dispatcher_dropdown'));
			$crud->callback_edit_field('cab_provider_id',array($this,'get_cab_provider_dropdown_edit'));
			$crud->callback_add_field('dispatcher_id',array($this->dispatcher,'get_dispatcher_dropdown'));
			$crud->callback_add_field('cab_provider_id',array($this,'cab_provider'));
			
			$crud->callback_column('cab_id',array($this->cab,'get_cab_by_id'));
			$crud->callback_column('dispatcher_id',array($this->dispatcher,'get_dispatcher_by_id'));
			
			$crud->display_as('cab_id','Cab#');
			$crud->display_as('dispatcher_id','Dispatcher');
		
			$output = $crud->render();
			//$this->pr($output);


            $content = $this->load->view('admin/driver.php',$output,true);
            // Pass to the master view
            $this->load->view('admin/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
    
	function call_before_insert($post_array){
		
		return $post_array;
	}
	function cab_provider(){
	
		return 	$this->cab_provider->get_cab_provider_dropdown(null,null);
	}
	
	function get_cab_provider_dropdown_edit($value,$row){
	
		return 	$this->cab_provider->get_cab_provider_dropdown($value,null);
	}

	
}