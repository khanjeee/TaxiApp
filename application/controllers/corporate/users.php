<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	var $user_data;
	
	function __construct()
	{   
		
		
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('grocery_CRUD');
		$this->load->helper('common_helper');
		$this->load->library('email');
		
		$this->load->model('Groups_Model','groups');
		$this->load->model('Corporate_Model','corporate');
		$this->load->model('Users_Model','users');
		$this->load->model('Cab_provider_Model','cab_provider');
		$this->load->model('Department_Model','department');
		$this->load->model('Driver_Model','driver');
		$this->load->model('Journey_type_Model','journey_type');
		
		
		
		$this->load->library('session');		
		$this->user_data=$this->session->all_userdata();
		if(isset($this->user_data['group_id']) ){
			if($this->user_data['group_id']!=7) {
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
			$session_data=$this->session->all_userdata();
			$crud->set_theme('datatables');
			$crud->set_table('users');
			$crud->where('corporate_id',$session_data['corporate_id']);
			$crud->set_subject('Users Info');
			$crud->required_fields('first_name','last_name','username','gender','phone','status','password','employee_id');
			
			$crud->columns('first_name','last_name','username','gender','phone','user_image','group_id','status','employee_id','message');
			$crud->fields('first_name','last_name','username','gender','phone','user_image','group_id','status','password','corporate_id','department_id','employee_id');
			//$crud->edit_fields('first_name','last_name','username','gender','phone','user_image','group_id','status','password');
			$crud->set_field_upload('user_image',UPLOAD_USER_IMAGE);
			$crud->field_type('password', 'password');
			$crud->field_type('corporate_id', 'hidden');
			$crud->field_type('group_id', 'hidden');
			
			//$crud->add_action('Message', '', '','ui-icon-image',array($this,'just_a_test'));
			
			$crud->unset_print();
			$crud->unset_export();
			$crud->set_rules('username', 'Username', 'callback_check_duplicate');
				
			/*@todo check username for duplicates and fix lisence no on update*/
			
			$crud->callback_column('message',array($this,'email_user'));
			$crud->callback_column('group_id',array($this->groups,'get_group_by_id'));
			$crud->callback_edit_field('password',array($this,'save_password_copy'));
			$crud->callback_column('employee_id',array($this,'generate_qr'));
					
			$crud->callback_field('cab_provider',array($this,'get_cab_provider_dropdown')); //dummy @kmdc
			$crud->callback_field('department_id',array($this->department,'get_department_dropdown'));
			
			//insertion of created_by not present in form
			$crud->callback_before_insert(array($this,'call_before_insert'));
			$crud->callback_after_insert(array($this,'call_after_insert'));
			$crud->callback_before_update(array($this,'call_before_update'));

			$crud->display_as('department_id','Department');
			
			$output = $crud->render();
			//$this->pr($output);

            $content = $this->load->view('corporate/users.php',$output,true);
            // Pass to the master view
            $this->load->view('corporate/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
    
	function call_before_insert($post_array){
		//$this->pr($post_array); die;
		
		//making md5 with salt before insertion
		$post_array['password']=md5(SALT.$post_array['password']);
		//check group id if corporate not selected set corporate id 0
		$post_array['corporate_id']=$this->user_data['corporate_id'];
		$post_array['department_id']=($this->user_data['group_id']!=5)? 0 : $post_array['department_id']; 
		$post_array['group_id']=5;
		return $post_array;
		
	
	}
	
	function call_after_insert($post_array,$primary_key){
	
		
		return $post_array;
	
	
	}
	
	function call_before_update($post_array){
	//making md5 only if the password is changed
	$post_array['password']=($post_array['password']==$post_array['password_copy'])? $post_array['password']  : md5(SALT.$post_array['password']);	
	return $post_array;
		
	}
	 function save_password_copy($value, $row){
	
	 	return "<input type='password' maxlength='255' value={$value} name='password' id='field-password'><input type='hidden' name='password_copy' value={$value}>";
	}
	
	function generate_qr($value, $row){
		$img=site_url('/assets/img/qr.png');
		$qr_url="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=id-{$row->id}&choe=UTF-8";
		return "<a href={$qr_url} download='{$row->first_name}_{$row->last_name}'><img width='50' height='50' src={$img}></a>";
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
	
	
	function get_journey_types_by_corporate_json($corporate_id)
	{
		echo $this->journey_type->get_journey_types_by_corporate_json($corporate_id);
	}
	
	function email_user($primary_key , $row)
	{
		$qr_url="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=id-{$row->id}&choe=UTF-8";
		$email=$row->username;
		$first_name=$row->first_name;
		$last_name=$row->last_name;
		$corporate=$this->corporate->get_corporate_name_by_id($row->corporate_id);
		$str = <<<EOD
<a onclick="javascript:send_email('$email','$first_name','$last_name','$qr_url','$corporate');" href="javascript:void(0)" class="edit_button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button">
							<span class="ui-button-icon-primary ui-icon  M75115bd4"></span><span class="ui-button-text">&nbsp;Message</span>
						</a>
EOD;
		return $str;
	}
	
	function email_user_info(){
		
		$email=$_POST['email'];
		$data=array('email'=>$email,
					'qr_url'=>$_POST['qr_url'],
					'first_name'=>$_POST['first_name'],
					'last_name'=>$_POST['last_name'],
					'corporate'=>$_POST['corporate']);
		
		$this->email->initialize(array(
				'mailtype' => 'html',
				'validate' => TRUE,
		));
		
		$mail_content = $this->load->view('email/template_user.php',$data,TRUE);
		$this->email->from('noreply@smarttaxi.com', 'SmartTaxi Admin');
		$this->email->to($email);
		$this->email->subject('Smart Taxi-User Details');
		$this->email->message($mail_content);
		if ($this->email->send()) {
			echo "email successfully sent to user {$email}";
		}else{
			echo($this->email->print_debugger()); //Display errors if any
		}
		
		
	}
	

	
	

	




}