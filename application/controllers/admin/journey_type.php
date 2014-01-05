<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Journey_type extends CI_Controller {

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



	function view()
	{		

		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('journey_type');
			$crud->set_subject('Journey type');
			$crud->required_fields('journey_type');
			
			$crud->columns('corporate_id','journey_type');
			$crud->fields('corporate_id','journey_type');
			
			
			$crud->unset_print();
			$crud->unset_export();
			
			$crud->callback_column('corporate_id',array($this->corporate,'get_corporate_name_by_id'));
			$crud->callback_add_field('corporate_id',array($this->corporate,'get_corporate_dropdown'));
			$crud->callback_edit_field('corporate_id',array($this->corporate,'get_corporate_dropdown'));
			
			
			
			
			$crud->display_as('corporate_id','Corporate');
			
			$output = $crud->render();
			//$this->pr($output);


            $content = $this->load->view('admin/journey_type.php',$output,true);
            // Pass to the master view
            $this->load->view('admin/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
    
	
	
	

}