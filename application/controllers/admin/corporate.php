<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Corporate extends CI_Controller {

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
			$crud->set_table('corporate');
			$crud->set_subject('Corporate Info');
			$crud->required_fields('name','email','phone_no','address');
			
			$crud->unset_print();
			$crud->unset_export();

			$crud->columns('name','license_no','email','phone_no','address');
			/*used to display fields when adding items*/
			$crud->fields('name','license_no','email','phone_no','address','cab_provider');

			/*Generating dropdwon for cab provider */
			//$crud->callback_add_field('status',array($this,'status_dropdown'));
			$crud->callback_field('cab_provider',array($this,'get_cab_provider_dropdown_multiple'));
			$crud->callback_edit_field('cab_provider',array($this,'get_cab_provider_dropdown_multiple_edit'));
			/*call back for edit form->passes value attribute with items value to the function
			 $crud->callback_edit_field('status',array($this,'status_dropdown'));
			$crud->callback_edit_field('section_id',array($this->sections,'get_sections_dropdown'));
			$crud->callback_edit_field('year_id',array($this->years,'get_years_dropdown'));
			$crud->callback_edit_field('department_id',array($this->departments,'get_departments_dropdown'));
			*/
			//insertion of created_by not present in form
			//$crud->callback_before_insert(array($this,'call_before_insert'));

			/*callback for table view
			 $crud->callback_column('status',array($this,'_status'));
			$crud->callback_column('section_id',array($this->sections,'get_section_by_id'));
			$crud->callback_column('year_id',array($this->years,'get_year_by_id'));
			$crud->callback_column('department_id',array($this->departments,'get_department_by_id'));
			*/
			$crud->callback_before_insert(array($this,'call_before_insert'));
			$crud->callback_after_insert(array($this,'call_after_insert'));
			$crud->callback_after_update(array($this,'call_after_update'));
			$crud->callback_after_delete(array($this,'call_after_delete'));


			/*hidding a field for insertion via call_before_insert crud requires field to be present in Crud->fields*/
			//	$crud->change_field_type('created_by','invisible');

			/*used to change names of the fields */
			$crud->display_as('license_no','License No');
			$crud->display_as('name','Name');
			$crud->display_as('phone_no','Phone No');
			$crud->display_as('email','Email');
			$crud->display_as('address','Address');
			$crud->display_as('cab_provider','Cab Provider');


			//$this->pr($crud);
			//die;
			$output = $crud->render();
			//$this->pr($output);


			$content = $this->load->view('admin/corporate.php',$output,true);
			// Pass to the master view
			$this->load->view('admin/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	function get_cab_provider_dropdown_multiple($value,$row){


		return $this->cab_provider->get_cab_provider_dropdown($row,'multiple');
	}

	function get_cab_provider_dropdown_multiple_edit($value,$row){



		return $this->cab_provider->get_cab_provider_dropdown_multiple_edit($row);

	}

	function call_after_insert($post_array,$corporate_id){
			

		//return 1 if failure 0 if success	2 if alredy present
		if($this->cc_provider->bulk_insert_corporate_cab_provider($post_array,$corporate_id)==0){
			

		}

	}

	function call_after_update($post_array,$corporate_id){
			
		/* * using transactions   * * */

		$this->db->trans_begin();
		try{
			$this->db->delete('corporate_cab_provider', array('corporate_id' => $corporate_id));
			$this->cc_provider->bulk_insert_corporate_cab_provider($post_array,$corporate_id);
			/*Commiting back transaction*/
			$this->db->trans_commit();
		}
		catch (Exception $e){
			/*ROlling back transaction*/
			$this->db->trans_rollback();
		}

	}

	function call_before_insert($post_array){

		//	print_r($post_array); die;
		return $post_array;


	}

	function call_after_delete($corporate_id){

		$this->db->delete('corporate_cab_provider', array('corporate_id' => $corporate_id));
			
	}















}