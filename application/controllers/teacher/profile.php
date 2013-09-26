<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct()
	{   
		
		
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('grocery_CRUD');
		$this->load->library('ion_auth');
		$this->load->library('phpbb_bridge');
		$this->load->model('Departments_Model','departments');
		$this->load->model('Years_Model','years');
		$this->load->model('Teachers_Model','teachers');
		$this->load->model('Groups_Model','groups');
		
		
		if (!$this->ion_auth->logged_in())
		{
			ci_redirect('authenticate/login');
		}
		
		if ($this->ion_auth->in_group(2))
		{
			$this->session->set_flashdata('message', 'You must be an admin to view this page');
			ci_redirect('/');
		}
		
	}




	function index()
	{
		
		//$add_forum_user=$this->phpbb_bridge->user_add('shoaibkhan105@live.com','shoaib','khanjee12');
		
		//$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}



	function view()
	{		
		
		$user = $this->ion_auth->user()->row();
		
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('flexigrid');
			$crud->set_table('user_teacher');
			$crud->where('user_id =', $user->id);
			$crud->set_subject('Update Profile');
			$crud->unset_add();
			$crud->unset_print();
			$crud->unset_export();
			$crud->unset_delete();

			$crud->required_fields('teacher_id','name','email','phone','qualification','institution','skills','designation');
			$crud->columns('teacher_id','name','email','phone','department_id','qualification','institution','skills','designation');
			
			/*used to display fields when adding items*/
			$crud->fields('user_id','name','teacher_id','forum_id','email','department_id','phone','qualification','institution','skills','designation');
			
			/*hidding a field for insertion via call_before_insert crud requires field to be present in Crud->fields*/
			$crud->change_field_type('user_id','invisible');
			$crud->change_field_type('forum_id','invisible');

			$crud->callback_add_field('department_id',array($this->departments,'get_departments_dropdown'));
			$crud->callback_edit_field('department_id',array($this->departments,'get_departments_dropdown'));
			
			/*hidding a field for insertion via call_before_insert crud requires field to be present in Crud->fields*/
			//$crud->change_field_type('created_by','invisible');
			
			/*used to change names of the fields*/
			$crud->display_as('teacher_id','Teacher Id');
			$crud->display_as('name','Name');
			$crud->display_as('email','Email');
			$crud->display_as('phone','Phone#');
			$crud->display_as('qualification','Qualification');
			$crud->display_as('skill','Skills');
			$crud->display_as('designation','Designation');
			$crud->display_as('institution','Institution');
			$crud->display_as('department_id','Department');

			
			//creating a user before creation of teacher
			$crud->callback_before_insert(array($this,'call_before_insert'));
			//deleting user from forum_users and users table
			$crud->callback_before_delete(array($this,'call_before_delete'));
			
			
			/*callback for table view */
			$crud->callback_column('department_id',array($this->departments,'get_department_by_id'));
			
			$output = $crud->render();
			//$this->pr($output);

            $content = $this->load->view('teacher/profile.php',$output,true);
            // Pass to the master view
            $this->load->view('teacher/master', array('content' => $content));



		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
    
	

	function call_before_insert($post_array){
		
		
		
		$username = $post_array['email'];
		$password = 'password';
		$email = $post_array['email'];
		$additional_data = array(
				'first_name' => $post_array['name'],
				'phone' => $post_array['phone']
		);
		
		
		/* * using transactions   * * */
		
		$this->db->trans_begin();
		
		//inserts user to forum_users table in PhpBB
		$forum_user_id=$this->phpbb_bridge->user_add($email,$username,$password);
		$group = array('3');
		
		$user_id=$this->ion_auth->register($username, $password, $email, $additional_data, $group);
		
		if( (!empty($user_id) && (!empty($forum_user_id)) ) ){
			$post_array['user_id']=$user_id;
			$post_array['forum_id']=$forum_user_id;
		
			//commit if both transactions above were successfull
			$this->db->trans_commit();
		}
		
		else{
			/*ROlling back transaction*/
			$this->db->trans_rollback();
				
		}
	
		
		return $post_array;
	
	}
	
	
	function call_before_delete($user_teacher_id){
		
		//getting forums users id 
		$user_teacher_row=$this->teachers->get_teacher_row($user_teacher_id);
		$forum_id=$user_teacher_row->forum_id;
		$user_id=$user_teacher_row->user_id;
		
		if(	(!empty($forum_id)) && (!empty($user_id))	){  //default value of forum id in db is 0
			
			/*deletes the user from phpbb forum*/
			$this->phpbb_bridge->user_delete($forum_id);
			/*deletes user from users table Ion_auth*/
			$this->ion_auth->delete_user($user_id);
		}
		

		
	}
	
	function get_teachers_by_course_id($value='') {
		//header('Content-Type: application/x-json; charset=utf-8');
		echo $this->teachers->get_teachers_by_course_id($value);
		
		
	
	}




}