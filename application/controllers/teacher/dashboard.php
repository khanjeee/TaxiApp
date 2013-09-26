<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{   
		
		
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('grocery_CRUD');
		$this->load->library('ion_auth');
		$this->load->model('Sections_Model','sections');
		$this->load->model('Years_Model','years');
		$this->load->model('Groups_Model','groups');
		
		
		if (!$this->ion_auth->logged_in())
		{
			ci_redirect('authenticate/login');
		}
		
		/* if (!$this->ion_auth->is_admin())
		{
			$this->session->set_flashdata('message', 'You must be an admin to view this page');
			redirect('/');
		} */
		
	}




	function index()
	{
		$user = $this->ion_auth->user()->row();
		
		// Pass to the master view
		$this->load->view('teacher/master',$user);
		
	}

	






}