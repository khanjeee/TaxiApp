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
		if(isset($session_data['group_id']) ){
			($session_data['group_id']==1) ? "" : 	ci_redirect('admin/login');
		
		}
		else{
			ci_redirect('admin/login');
		}
		
		/*
		if (!$this->ion_auth->logged_in())
		{
				$this->load->view('admin/login');
		}
		
		/* if (!$this->ion_auth->is_admin())
		{
			$this->session->set_flashdata('message', 'You must be an admin to view this page');
			redirect('/');
		} */
		
	}




	function index()
	{
		// Pass to the master view
		$data=$this->payment->get_total_trips();//get total trips and their total amount
        $content = $this->load->view('admin/dashboard.php', $data ,true);
        //$this->pr($data); die;
        $this->load->view('admin/master', array('content' => $content));

		
	}
	
	







}