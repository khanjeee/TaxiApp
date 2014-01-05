<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	public $lisence_no;
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
			$crud->set_table('users');
			$crud->set_subject('Users Info');
			$crud->required_fields('first_name','last_name','username','gender','phone','user_image','group_id','status','password');
			
			$crud->columns('first_name','last_name','username','gender','phone','user_image','group_id','status');
			$crud->fields('first_name','last_name','username','gender','phone','user_image','group_id','status','password','corporate_id','department_id','cab_provider','lisence_no','employee_id');
			//$crud->edit_fields('first_name','last_name','username','gender','phone','user_image','group_id','status','password');
			$crud->set_field_upload('user_image',UPLOAD_USER_IMAGE);
			$crud->field_type('password', 'password');
			
			$crud->unset_print();
			$crud->unset_export();
			$crud->set_rules('username', 'Username', 'callback_check_duplicate');
				
			/*@todo check username for duplicates and fix lisence no on update*/
			
			/*Generating dropdwons for year section and course status
			$crud->callback_add_field('status',array($this,'status_dropdown'));
			$crud->callback_add_field('section_id',array($this->sections,'get_sections_dropdown'));
			$crud->callback_add_field('year_id',array($this->years,'get_years_dropdown'));
			
			*/
			
			$crud->callback_column('group_id',array($this->groups,'get_group_by_id'));
			$crud->callback_add_field('group_id',array($this->groups,'get_groups_dropdown'));
			$crud->callback_add_field('corporate_id',array($this->corporate,'get_corporate_dropdown'));
			$crud->callback_edit_field('corporate_id',array($this->corporate,'get_corporate_dropdown'));
			$crud->callback_edit_field('group_id',array($this->groups,'get_groups_dropdown'));
			$crud->callback_edit_field('password',array($this,'save_password_copy'));
			$crud->callback_edit_field('lisence_no',array($this,'lisence_no'));
					
			$crud->callback_field('cab_provider',array($this,'get_cab_provider_dropdown')); //dummy @kmdc
			$crud->callback_field('department_id',array($this->department,'get_department_dropdown'));
			
			
			/*call back for edit form->passes value attribute with items value to the function
			$crud->callback_edit_field('status',array($this,'status_dropdown'));
			$crud->callback_edit_field('section_id',array($this->sections,'get_sections_dropdown'));
			$crud->callback_edit_field('year_id',array($this->years,'get_years_dropdown'));
			$crud->callback_edit_field('department_id',array($this->departments,'get_departments_dropdown'));
			*/
			//insertion of created_by not present in form
			$crud->callback_before_insert(array($this,'call_before_insert'));
			$crud->callback_after_insert(array($this,'call_after_insert'));
			$crud->callback_before_update(array($this,'call_before_update'));

			/*callback for table view 
			$crud->callback_column('status',array($this,'_status'));
			$crud->callback_column('section_id',array($this->sections,'get_section_by_id'));
			$crud->callback_column('year_id',array($this->years,'get_year_by_id'));
			$crud->callback_column('department_id',array($this->departments,'get_department_by_id'));
		*/
			
			/*used to display fields when adding items*/
			//$crud->fields('code','name','department_id','description','status','section_id','year_id','created_by');
			/*hidding a field for insertion via call_before_insert crud requires field to be present in Crud->fields*/
		//	$crud->change_field_type('created_by','invisible');
			
			/*used to change names of the fields*/
			
			$crud->display_as('corporate_id','Corporate');
			$crud->display_as('department_id','Department');
			$crud->display_as('group_id','Group');
			
			$output = $crud->render();
			//$this->pr($output);


            $content = $this->load->view('admin/users.php',$output,true);
            // Pass to the master view
            $this->load->view('admin/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
    
	function call_before_insert($post_array){
		//$this->pr($post_array); die;
		$this->lisence_no=$post_array['lisence_no'];
		unset($post_array['lisence_no']);
		//making md5 with salt before insertion
		$post_array['password']=md5(SALT.$post_array['password']);
		//check group id if corporate not selected set corporate id 0
		$post_array['corporate_id']=($post_array['group_id']!=5)? 0 : $post_array['corporate_id'];
		$post_array['department_id']=($post_array['group_id']!=5)? 0 : $post_array['department_id'];
		return $post_array;
		
	
	}
	
	function call_after_insert($post_array,$primary_key){
	
		if($post_array['group_id']==6){
			
			$data = array(
					'name' => $post_array['first_name'].' '.$post_array['last_name'] ,
					'gender' => $post_array['gender'] ,
					'contact_no' => $post_array['phone'],
					'license_code' => $this->lisence_no,
					'user_id' => $primary_key,
					'pob_status' => 'no',
					'post_check_in' => 'no',
					'cab_provider_id' => $post_array['cab_provider_id'],
					'image_url' => $post_array['user_image']
					
			);
			
			$this->db->insert('driver_information', $data);
			
		}
		
		return $post_array;
	
	
	}
	
	function call_before_update($post_array){
	//making md5 only if the password is changed
	$post_array['password']=($post_array['password']==$post_array['password_copy'])? $post_array['password']  : md5(SALT.$post_array['password']);	
	//print_r($post_array['password']); die;
	if($post_array['group_id']==6){
		
		$user_id=$this->uri->segment(5);
		$data = array(
					'name' => $post_array['first_name'].' '.$post_array['last_name'] ,
					'gender' => $post_array['gender'] ,
					'contact_no' => $post_array['phone'],
					'license_code' => $post_array['lisence_no'],
					'cab_provider_id' => $post_array['cab_provider_id'],
					'image_url' => $post_array['user_image']
					
			);
		 
		$this->db->where('user_id', $user_id);
		$this->db->update('driver_information',$data);
	}
	unset($post_array['lisence_no']);
	return $post_array;
		
	
	
	}
	 function save_password_copy($value, $row){
	
	 	return "<input type='password' maxlength='255' value={$value} name='password' id='field-password'><input type='hidden' name='password_copy' value={$value}>";
	}
	
	function lisence_no($value, $row){
		
		$user_id=$this->uri->segment(5);
		$lisence_code=$this->driver->get_lisence_code_by_user_id($user_id);
		return "<input id='field-lisence_no' name='lisence_no' type='text' value='{$lisence_code}'>";
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
	

	
	
	

	
	

	




}