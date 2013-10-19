<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->database();

	}

	//ci_redirect if needed, otherwise display the user list
	function index()
	{

		$this->logout();
	}

	
	
	function logout(){
		$this->session->sess_destroy();
		$this->session->set_flashdata('message', 'Logged out successfully');
		//ci_redirect them to the login page
		ci_redirect('admin/login', 'refresh');
		
	}
	
	
}
