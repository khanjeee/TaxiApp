<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Questions extends CI_Controller {

	function __construct()
	{   
	
		
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('grocery_CRUD');
		$this->load->library('ion_auth');
		$this->load->model('course_Lecture_Model','lectures');
		$this->load->model('Years_Model','years');
		$this->load->model('Courses_Model','courses');
		$this->load->model('Users_Model','users');
		$this->load->model('Common_Model','common');
		$this->load->model('Answers_Model','answers');
		$this->load->model('Questions_Model','questions');
		$this->load->model('assign_Course_Model','assigned');
		
		
		if (!$this->ion_auth->logged_in())
		{
			ci_redirect('authenticate/login');
		}
		
		if (!$this->ion_auth->is_admin())
		{
			$this->session->set_flashdata('message', 'You must be an admin to view this page');
			ci_redirect('');
		}
		
	}




	function index()
	{
		ci_redirect('admin/questions/view');
		
		//$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	function topic_select()
	{	
		
		
		$lectures= $this->lectures->get_topic_dropdown();
		$courses=$this->assigned->get_assigned_course_dropdown();
		$years= $this->years->get_years_dropdown(1);
		$content = $this->load->view('admin/topics.php',
									array('lectures' => $lectures,'courses' => $courses,'years'=>$years),true);
		// Pass to the master view
		$this->load->view('admin/master', array('content' => $content));
		
	}
	

	function view()
	{		
		
	
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('flexigrid');
			$crud->set_table('questions');
			$crud->where('lecture_id =', $this->uri->segment(4));
			$crud->set_subject('Questions');
			$crud->required_fields('lecture_id','question','type','reason');
			
			$crud->columns('lecture_id','question');
			
			
			
			/*used to display fields when adding items*/
			$crud->fields('year','course','lecture_id','question','type','answers','reason','created_by');//adding fake field answers
			
			$crud->field_type('created_by', 'invisible');
			
			$crud->callback_field ( 'answers', array ( $this,'callback_add_answers' ) );//populating answers from
			$crud->callback_field ( 'year', array ( $this->years,'get_years_dropdown' ) );
			$crud->callback_field ( 'course', array ( $this->assigned,'get_assigned_course_dropdown' ) );
			//$crud->callback_field ( 'tester', array ( $this,'tester' ) );
			$crud->callback_edit_field( 'answers', array ( $this,'callback_edit_answers' ) );
			/*hidding a field for insertion via call_before_insert crud requires field to be present in Crud->fields*/
		
			
			/*used to change names of the fields*/
			$crud->display_as('lecture_id','Topic');
			$crud->display_as('question','Question');
			
			$crud->callback_add_field('lecture_id',array($this->lectures,'get_topic_dropdown'));
			$crud->callback_add_field('type',array($this->common,'answer_type_dropdown'));
			
			/*call back for edit form->passes value attribute with items value to the function*/
		/* 	$crud->callback_edit_field('status',array($this->common,'status_dropdown'));
			$crud->callback_edit_field('section_id',array($this->sections,'get_sections_dropdown'));
			$crud->callback_edit_field('year_id',array($this->years,'get_years_dropdown'));*/
			
			$crud->callback_edit_field('type',array($this->common,'answer_type_dropdown'));
			$crud->callback_edit_field('lecture_id',array($this->lectures,'get_topic_dropdown'));
			
			/*callback for table view */
			$crud->callback_column('lecture_id',array($this->lectures,'get_topic_by_lectureid'));
			
				
			$crud->callback_before_insert(array($this,'call_before_insert'));
			$crud->callback_after_insert(array($this,'call_after_insert'));
			
			$crud->callback_before_update(array($this,'call_before_update'));
			$crud->callback_after_update(array($this,'call_after_update'));
			
			$crud->callback_after_delete(array($this,'call_after_delete'));
			
			
			$output = $crud->render();
			//$this->pr($output);


            $content = $this->load->view('admin/questions.php',$output, true);
            // Pass to the master view
            $this->load->view('admin/master', array('content' => $content));


        }catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	
	function  callback_add_answers(){
	
		return $this->load->view('static/questions_form.php', NULL, true);  //static form html for answers
	}

	function  callback_edit_answers($answer,$question_id){
		 
		$question_type=$this->questions->get_question_type($question_id); //get question type 
		
		if($question_type=='MCQ'){
			$answers=$this->answers->get_answers_by_question_id($question_id);//getting answers MCQS
			return $this->load->view('static/questions_form.php', $answers, true);  //static form html for answers
		}
		if($question_type=='TRUE/FALSE'){
			$answers=$this->answers->get_answers_by_question_id($question_id);
			return $this->load->view('static/true_false_form.php', $answers, true);  //static form html for answers
		}
		}
    
	
	function call_before_insert($post_array){
			//$this->pr($post_array); die;
	$post_array['created_by']=$this->users->get_user_id();
		 return $post_array;
	}
	
	function call_after_insert($post_array,$question_id){
	$this->answers->insert_answers($post_array,$question_id);
	
	}

	function call_before_update($post_array){
		//$this->pr($post_array); die;
		$post_array['created_by']=$this->users->get_user_id();
		return $post_array;
	}
	
	function call_after_update($post_array,$question_id){
		$this->answers->update_answers($post_array,$question_id);
	
	}
	
function call_after_delete($question_id){
		$this->answers->delete_answers($question_id);
	
	}



}