<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {
	
	public   $promoted_students=array();

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
		$this->load->helper('common_helper');
		$this->load->library('session');
		$this->load->model('Corporate_Model','corporate');
		
	}

	function insert()
	{
		
		$arr=array();
	
	try{
		
			if(isset($_POST['assign_course_id'])){
				$assign_course_id=(int)$_POST['assign_course_id'];
				$date=$_POST['date'];
				unset($_POST['year_id']);
				unset($_POST['search_text']);
				unset($_POST['search_field']);
				unset($_POST['per_page']);
				unset($_POST['order_by']);
				unset($_POST['page']);
				unset($_POST['assign_course_id']);
				unset($_POST['date']);
					
				//$this->pr($_POST);die;
				if(!empty($_POST)){
				foreach ($_POST as $key=>$data){
					$arr_inner=array();
					$arr_inner['student_id']=$key;
					$arr_inner['assign_course_id']=$assign_course_id;
					$arr_inner['is_present']=(int)$data;
					$arr_inner['date']=$date;
					$arr[]=$arr_inner;
		
				}
					
				$this->db->insert_batch('attendance', $arr);
				//echo'attendance marked successfully';
				$status = array('status'  => 'attendance successfully marked');
				$this->session->set_flashdata('status', $status);
				ci_redirect("admin/attendance");
				
				}
				else{
					$status = array('status'  => 'Nothing selected');
					$this->session->set_flashdata('status', $status);
					ci_redirect("admin/attendance");
				}	
				//ci_redirect("admin/attendance");
			}
			else{
				$status = array('status'  => 'attendance could not be  marked');
				$this->session->set_flashdata('status', $status);
				ci_redirect("admin/attendance");
			
			}
	}
	catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
		//$this->pr($_POST);
	
	
	
		//$this->pr($arr);
	
		//test_method('Hello World');
		//$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	function select_customer()
	{
		$status=$this->session->flashdata('status');
		$users=$this->users->get_users_dropdown(1);
		$corporate=$this->corporate->get_corporate_dropdown(1);
		$content = $this->load->view('admin/select_customer.php',	array('users' => $users,'corporate' => $corporate),true);
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
			//$crud->unset_print();
			//$crud->unset_export();
			$crud->unset_delete();
			$crud->unset_edit();
			
			//$crud->unset_jquery();
			//$crud->unset_jquery_ui();
			//$crud->unset_columns();
			
			
			
			/* if(intval($this->uri->segment(4))) {	//returns students by year if 4th segment exist			
		//	$crud->where('assign_course_id =', intval($this->uri->segment(4)));
			$crud->where('batch_year =', $this->uri->segment(5));
			$crud->where('section_id =', $this->uri->segment(6));
			
			}
			else{
				$crud->where('year_id =',0); //hide all students if not id passed
			} */
			
			$crud->columns('first_name','payment_type','pickup_door_address','pickup_time','amount','driver_name');
			
			$crud->callback_column('amount',array($this,'append_currency'));
				
			$output = $crud->render();
			
			

            $content = $this->load->view('admin/customer_report.php',$output,true);
            // Pass to the master view
            $this->load->view('admin/master', array('content' => $content));

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	function check_attendance(){
		
		echo $this->attendance->check_attendance($_POST);
	}
    
	function append_currency($value,$id){//if checked checkbox is posted else hidden field
		
		return CURRENCY_UNIT.$value; //currency unit is constant set in contants
	
	}
	
	

}