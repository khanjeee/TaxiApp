<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common extends CI_Controller {

	function __construct()
	{
	
	
		parent::__construct();
	
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
	
		$this->load->model('Sections_Model','sections');
		$this->load->model('Years_Model','years');
		$this->load->helper('common_helper');
	
	
	
	}
	
	
	
	public function index()
	{
		
	}
	
	function years_dropdown($param) {
	
		return  form_dropdown('year_id', $this->years->get_years_dropdown());
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
