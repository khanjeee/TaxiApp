<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	
	function __construct()
	{   
		
		
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('grocery_CRUD');
		$this->load->library('session');
		$this->load->model('Payment_Model','payment');
		$session_data=$this->session->all_userdata();
		if(isset($session_data['group_id']) ){ // 7 is Corporate Admin
			($session_data['group_id']==7) ? "" : 	ci_redirect('admin/login');
		
		}
		else{
			ci_redirect('admin/login');
		}
		
		
		
	}




	function index()
	{
		$session_data=$this->session->all_userdata();
		
		$data=$this->payment->get_total_trips_corporate($session_data['corporate_id']);//get total trips and their total amount
        $content = $this->load->view('corporate/dashboard.php', $data ,true);
        // Pass to the master view
        $this->load->view('corporate/master', array('content' => $content));
        
	}







}