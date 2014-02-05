<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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

		$this->login();
	}

	//log the user in
	function login()
	{
		//display flash messeg id some thing present in session 
		$this->data['message']=($this->session->flashdata('message')) ? $this->session->flashdata('message') : "";
		$this->load->view('admin/login', $this->data);

	}

	function  verify_login(){
		$email= $this->input->post('identity');
		$password=$this->input->post('password');

		$resp=$this->curl($email,$password);
		if(!empty($resp)){
			$json_data=json_decode($resp,true);
			
			if(isset($json_data['body']['User'])){
				if($json_data['body']['User']['group_id']==1){// set session if group id is 1
					
					$this->session->set_userdata($json_data['body']['User']); //set data in session
					ci_redirect('admin/dashboard');  // send to admin page 
				}
				
			elseif ($json_data['body']['User']['group_id']==7){// set session if group id is 5 and redirect to corporate
						
					$this->session->set_userdata($json_data['body']['User']); //set data in session
					ci_redirect('corporate/dashboard');  // send to admin page
				}
				else{
					$this->data['message']="Only administrators are allowed to login";
					$this->load->view('admin/login', $this->data);
				}
			}
			else{
				$this->data['message']="Invalid user id password";
				$this->load->view('admin/login', $this->data);
			}
			//$this->pr($json_data);
		}
		else{
			$this->data['message']="Bad Request";
			$this->load->view('admin/login', $this->data);
		}
	}

	function curl($username,$passowrd){

try{
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => LOGIN_SERVICE_URL,
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => array(
						'username' => $username,
						'password' => $passowrd
				)
		));
		// Send the request & save response to $resp
		$resp = curl_exec($curl);
		// Close request to clear up some resources
		curl_close($curl);

		return $resp;
	}
	catch (Exception $e){
		return null;
	}

	}
	
	
	
	
}
