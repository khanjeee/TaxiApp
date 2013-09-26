<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Departments extends CI_Controller {

	function __construct()
	{   
		
		
		parent::__construct();

		$this->load->database();
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('grocery_CRUD');
		$this->load->library('ion_auth');
		
		
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
		
		//$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}



	function view()
	{		
		

		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('flexigrid');
			$crud->set_table('departments');
			$crud->set_subject('Departments');
			$crud->required_fields('name');
			
			
			$crud->columns('name');
			
			/*used to display fields when adding items*/
			$crud->fields('name');
	
			
			/*used to change names of the fields*/
			
			$crud->display_as('name','Name');
			
			
			
			$output = $crud->render();
			//$this->pr($output);

            $content = $this->load->view('admin/departments.php',$output,true);
            // Pass to the master view
            $this->load->view('admin/master', array('content' => $content));


        }catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
    
	

	
	
	




}