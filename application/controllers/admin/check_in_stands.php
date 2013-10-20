<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Check_in_stands extends CI_Controller {

	function __construct()
	{


		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('grocery_CRUD');
		$this->load->helper('common_helper');
		$this->load->model('Cab_provider_Model','cab_provider');
		$this->load->model('Corporate_cab_provider_Model','cc_provider');
		
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
		//test_method('Hello World');
		//$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}



	function view()
	{
	


		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('check_in_stands');
			$crud->set_subject('Check In Stands');
			$crud->required_fields('name','status');
			$crud->set_rules('latitude','Latitude','numeric|required');
			$crud->set_rules('longitude','Longitude','numeric|required');
			$crud->columns('name','latitude','longitude','status');
			/*used to display fields when adding items*/
			$crud->fields('name','latitude','longitude','status');
			
			$crud->unset_print();
			$crud->unset_export();

		
			$output = $crud->render();
			//$this->pr($output);


			$content = $this->load->view('admin/check_in_stands.php',$output,true);
			// Pass to the master view
			$this->load->view('admin/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	















}