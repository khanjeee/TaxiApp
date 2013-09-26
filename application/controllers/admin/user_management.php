<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_management extends CI_Controller {

	function __construct()
	{   
		
		
		parent::__construct();

		
		$this->load->library('ion_auth');
		$this->load->library('form_validation');
        $this->load->library('grocery_CRUD');

		
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		
		$this->lang->load('auth');
		$this->load->helper('language');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('url');
		
		$this->load->database();
		
		$this->load->library('ion_auth');
		
		
		
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
	
		
		//set the flash data error message if there is one
		 $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		
		
		//$this->load->view('admin/user_management.php');
		$this->data['users'] = $this->ion_auth->users()->result();
		foreach ($this->data['users'] as $k => $user)
		{
			$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
		}

        //$content = $this->_render_page('admin/user_management', $this->data, true);
        $this->viewdata = (empty($data)) ? $this->data: null;
        //$content = $this->load->view($view, $this->viewdata, true);
        $content = $this->load->view('admin/user_management', $this->viewdata, true);
        // Pass to the master view
        $this->load->view('admin/master', array('content' => $content));


    }

	
	function _render_page($view, $data=null, $render=false)
	{
	
		$this->viewdata = (empty($data)) ? $this->data: $data;
	
		$view_html = $this->load->view($view, $this->viewdata, $render);
	
		if (!$render) return $view_html;
	}






}