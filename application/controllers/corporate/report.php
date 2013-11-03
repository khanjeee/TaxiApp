<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

	public   $payment_count=0;
	public   $journey_count=0;

	function __construct()
	{


		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('grocery_CRUD');
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
		$this->load->model('Users_Model','users');
		$this->load->model('Driver_Model','drivers');
		$this->load->helper('common_helper');
		$this->load->library('session');
		$this->load->model('Corporate_Model','corporate');

		$session_data=$this->session->all_userdata();
		if(isset($session_data['group_id']) ){
			if($session_data['group_id']!=5) {
				$this->session->set_flashdata('message', 'You must be an admin to view this page');
				ci_redirect('admin/login','refresh');
			}



		}
		else{
			$this->session->set_flashdata('message', 'You must login to view this page');
			ci_redirect('admin/login','refresh');

		}

	}



	function select_customer()
	{
		$session_data=$this->session->all_userdata();
		$status=$this->session->flashdata('status');
		$corporate_id=$this->users->get_corporate_id($session_data['id']);
		$users=$this->users->get_users_by_corporate_dropdown($corporate_id);
		$content = $this->load->view('corporate/select_customer.php',	array('users' => $users,'corporate_id' => $corporate_id),true);
		$this->load->view('corporate/master', array('content' => $content));
	}


	function select_corporate()
	{
		$session_data=$this->session->all_userdata();
		$status=$this->session->flashdata('status');
		$corporate_id=$this->users->get_corporate_id($session_data['id']);
		$content = $this->load->view('corporate/select_corporate.php',	array('corporate_id' => $corporate_id),true);
		$this->load->view('corporate/master', array('content' => $content));
	}

	function select_driver()
	{
		$status=$this->session->flashdata('status');
		$drivers=$this->drivers->get_driver_dropdown(1);
		$corporate=$this->corporate->get_corporate_dropdown(1);
		$content = $this->load->view('admin/select_driver.php',	array('drivers' => $drivers,'corporate' => $corporate),true);
		$this->load->view('admin/master', array('content' => $content));
	}

	function index()
	{   /* $yearaa=1;
		$year="admin/promote_students/view/{$yearaa}";
		ci_redirect($year); */
		$this->select_customer();
	}



	function customer_report()
	{

		//print_r($_POST) ; die;

		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('users');
			$crud->set_subject('Customer Report');
			$crud->set_model('customer_report');
			$crud->unset_add();
			$crud->unset_print();
			//$crud->unset_export();
			$crud->unset_delete();
			$crud->unset_edit();

			$crud->columns('first_name','payment_type','pickup_door_address','pickup_time','amount','driver_name');
			$crud->callback_column('amount',array($this,'append_currency'));

			$output = $crud->render();
			$output->payment_count=$this->payment_count;	//passing payment count tot he view
			$output->journey_count= $this->journey_count;

			$content = $this->load->view('corporate/customer_report.php',$output,true);
			// Pass to the master view
			$this->load->view('corporate/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}



	function corporate_report()
	{

		//print_r($_POST) ; die;

		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('users');
			$crud->set_subject('Corporate Report');
			$crud->set_model('corporate_report');
			$crud->unset_add();
			$crud->unset_print();
			//$crud->unset_export();
			$crud->unset_delete();
			$crud->unset_edit();

			$crud->columns('first_name','payment_type','pickup_door_address','pickup_time','amount','driver_name');

			$crud->callback_column('amount',array($this,'append_currency'));

			$output = $crud->render();
			$output->payment_count=$this->payment_count;	//passing payment count tot he view
			$output->journey_count= $this->journey_count;

			//$this->pr($output);
			$content = $this->load->view('corporate/corporate_report.php',$output,true);
			// Pass to the master view
			$this->load->view('corporate/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	function driver_report()
	{
			
		//print_r($_POST) ; die;
			
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('datatables');
			$crud->set_table('users');
			$crud->set_subject('Driver Report');
			$crud->set_model('driver_report');
			$crud->unset_add();
			$crud->unset_print();
			//$crud->unset_export();
			$crud->unset_delete();
			$crud->unset_edit();

			$crud->columns('driver_name','first_name','payment_type','pickup_door_address','pickup_time','amount');
			$crud->display_as('first_name','Customer Name');
			$crud->callback_column('amount',array($this,'append_currency'));

			$output = $crud->render();
			$output->payment_count=$this->payment_count;	//passing payment count tot he view
			$output->journey_count= $this->journey_count;
			
			
				
			//$this->pr($output);
			$content = $this->load->view('admin/corporate_report.php',$output,true);
			// Pass to the master view
			$this->load->view('admin/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	function append_currency($value,$id){//if checked checkbox is posted else hidden field

		$this->payment_count+=$value;
		$this->journey_count+=1;
		return CURRENCY_UNIT.$value; //currency unit is constant set in contants

	}



}