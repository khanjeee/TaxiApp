<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  AUthentacion
*
* Author: Shoaib AHmed Khan
*		  shoaibkhan105@outlook.com

* Requirements: PHP5 or above
*
*/

class Authentication
{
	
	Public static  $is_logged_in;
	Public static  $user_group;

		
	public function set_data($user_data)
		{
		if(isset($user_data)){
				 
				Authentication::$user_group=($user_data['group_id']==1)? 1 : 0;
				Authentication::$is_logged_in=(Authentication::$user_group==1)? TRUE : FALSE;
				
				}
		else{
				Authentication::$is_logged_in=FALSE;
				Authentication::$user_group=0;
		}
		}
		
		public function is_admin(){
			return Authentication::$is_logged_in;	
		}
		//die('i am called');
			/*$this->load->library('session');
			$session_data=$this->session->all_userdata();
			if(isset($session_data['group_id']) ){
				($session_data['group_id']==1) ? $this->index() : 	ci_redirect('admin/login');
			
			}
			else{
				ci_redirect('admin/login');
			}
*/

	}

	
