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
		$session_data=$this->session->all_userdata();
		if(isset($session_data['group_id']) ){
			($session_data['group_id']==5) ? "" : 	ci_redirect('admin/login');
		
		}
		else{
			ci_redirect('admin/login');
		}
		
		
		
	}




	function index()
	{
        $content = $this->load->view('corporate/dashboard.php', null ,true);
        // Pass to the master view
        $this->load->view('corporate/master', array('content' => $content));

		
	}







}