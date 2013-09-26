<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifications extends CI_Controller {

	function __construct()
	{   
		
		
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('grocery_CRUD');
		$this->load->library('ion_auth');
		$this->load->model('Sections_Model','sections');
		$this->load->model('Years_Model','years');
		$this->load->model('Groups_Model','groups');
		$this->load->model('Common_Model','common');
		
		
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
			$crud->set_table('notification_board');
			$crud->set_subject('Notification Board');

			$crud->columns('news','news_desc','section_id','year_id','group_id','status');
			
			/*Generating dropdwons for year section and course status*/
			$crud->callback_add_field('status',array($this->common,'status_dropdown'));
			$crud->callback_add_field('section_id',array($this->sections,'get_sections_dropdown'));
			$crud->callback_add_field('year_id',array($this->years,'get_years_dropdown'));
			$crud->callback_add_field('group_id',array($this->groups,'get_groups_dropdown'));
			
			/*used to display fields when adding items*/
			$crud->fields('news','news_desc','status','section_id','year_id','group_id');
			
			/*hidding a field for insertion via call_before_insert crud requires field to be present in Crud->fields*/
			//$crud->change_field_type('created_by','invisible');
			
			/*used to change names of the fields*/
			$crud->display_as('news','Title');
			$crud->display_as('news_desc','Description');
			$crud->display_as('status','Status');
			$crud->display_as('section_id','Section');
			$crud->display_as('year_id','Year');
			$crud->display_as('group_id','Group');
			
			
			/*call back for edit form->passes value attribute with items value to the function*/
			$crud->callback_edit_field('status',array($this->common,'status_dropdown'));
			$crud->callback_edit_field('section_id',array($this->sections,'get_sections_dropdown'));
			$crud->callback_edit_field('year_id',array($this->years,'get_years_dropdown'));
			$crud->callback_edit_field('group_id',array($this->groups,'get_groups_dropdown'));
			
			/*callback for table view */
			$crud->callback_column('status',array($this->common,'_status'));
			$crud->callback_column('section_id',array($this->sections,'get_section_by_id'));
			$crud->callback_column('year_id',array($this->years,'get_year_by_id'));
			$crud->callback_column('group_id',array($this->groups,'get_group_by_id'));
			
			$output = $crud->render();
			//$this->pr($output);


            $content = $this->load->view('admin/notifications_board.php',$output, true);
            // Pass to the master view
            $this->load->view('admin/master', array('content' => $content));


        }catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
    
	




}