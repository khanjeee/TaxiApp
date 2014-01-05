<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

	public   $payment_count=0;
	public   $journey_count=0;
	public   $smart_taxi_earning=0;
	public   $tip_count=0;

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
		$this->load->model('Journey_type_Model','journey_type');
		
		

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



	function select_customer()
	{
		$status=$this->session->flashdata('status');
		$users=$this->users->get_users_dropdown(1);
		$corporate=$this->corporate->get_corporate_dropdown(1);
		$content = $this->load->view('admin/select_customer.php',	array('users' => $users,'corporate' => $corporate),true);
		$this->load->view('admin/master', array('content' => $content));
	}


	function select_corporate()
	{
		$status=$this->session->flashdata('status');
		$corporate=$this->corporate->get_corporate_dropdown(1);
		$journey_type=$this->journey_type->get_journey_type_dropdown(0);
		$content = $this->load->view('admin/select_corporate.php',	array('corporate' => $corporate,'journey_type'=>$journey_type),true);
		
		$this->load->view('admin/master', array('content' => $content));
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
			
			$crud->columns('first_name','payment_type','pickup_door_address','pickup_time','dropOff_door_address','dropOff_time','amount','driver_name','tip_given');
			$crud->callback_column('amount',array($this,'calculate_total_amount'));

			$crud->display_as('first_name','Customer Name');
			$crud->display_as('amount','Trip Fare');
			$crud->callback_column('tip_given',array($this,'tip_given'));
				
			
			$output = $crud->render();
			$output->payment_count=$this->payment_count;	//passing payment count tot he view
			$output->journey_count= $this->journey_count;
			$output->tip_count= $this->tip_count;

			$content = $this->load->view('admin/customer_report.php',$output,true);
			// Pass to the master view
			$this->load->view('admin/master', array('content' => $content));

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

			$crud->columns('first_name','payment_type','pickup_door_address','pickup_time','dropOff_door_address','dropOff_time','amount','driver_name','tip_given');

			$crud->callback_column('amount',array($this,'calculate_total_amount'));
			
			$crud->display_as('first_name','Customer Name');
			$crud->display_as('amount','Trip Fare');
			$crud->callback_column('tip_given',array($this,'tip_given'));

			$output = $crud->render();
			$output->payment_count=$this->payment_count;	//passing payment count tot he view
			$output->journey_count= $this->journey_count;
			$output->tip_count= $this->tip_count;

			//$this->pr($output);
			$content = $this->load->view('admin/corporate_report.php',$output,true);
			// Pass to the master view
			$this->load->view('admin/master', array('content' => $content));

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

			$crud->columns('driver_name','first_name','payment_type','pickup_door_address','pickup_time','dropOff_door_address','dropOff_time','amount','tip_given','smart_taxi_earning');
			$crud->display_as('first_name','Customer Name');
			$crud->display_as('amount','Trip Fare');
			$crud->callback_column('amount',array($this,'calculate_total_amount'));
			$crud->callback_column('tip_given',array($this,'tip_given'));
			$crud->callback_column('smart_taxi_earning',array($this,'calculate_smart_taxi_earning'));
				
			
			$output = $crud->render();
			$output->payment_count=$this->payment_count;	//passing payment count tot he view
			$output->journey_count= $this->journey_count;
			$output->smart_taxi_earning=$this->smart_taxi_earning;
			$output->tip_count= $this->tip_count;
			
				
			//$this->pr($output);
			$content = $this->load->view('admin/driver_report.php',$output,true);
			// Pass to the master view
			$this->load->view('admin/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}

	function calculate_total_amount($value,$id){//if checked checkbox is posted else hidden field

		$this->payment_count+=$value;
		$this->journey_count+=1;
		$amount=$value;
		return CURRENCY_UNIT.$amount; //currency unit is constant set in contants

	}
	function calculate_smart_taxi_earning($value,$row){//if checked checkbox is posted else hidden field
	
		$this->smart_taxi_earning+=intval(str_replace('$', '', $row->amount))*(0.15); //currency unit is constant set in contants
		return CURRENCY_UNIT.intval(str_replace('$', '', $row->amount))*(0.15);
	}
	
	function tip_given($value,$row){//if checked checkbox is posted else hidden field
		$this->tip_count+=$value;
		return CURRENCY_UNIT.$value;
	}



}