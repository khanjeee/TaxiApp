<?php

class Answers_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
   
   
    
    function insert_answers($post_array,$question_id,$is_update=0)
    {
    	$arrCount= array(); //counter for options set a ket for each option 
    	$dataArr= array();
    	$answerArr= array();
    	if($post_array['type']=='MCQ'){
    		
    	if(!empty($post_array['option_1'])){
    		$arrCount[0]['option']=$post_array['option_1'];
    		$arrCount[0]['checked']=(array_key_exists('checked_1', $post_array))? 1 :0 ;
    	}
    	if(!empty($post_array['option_2'])){
    		$arrCount[1]['option']=$post_array['option_2'];
    		$arrCount[1]['checked']=(array_key_exists('checked_2', $post_array))? 1 :0 ;
    	}
    	if(!empty($post_array['option_3'])){
    		$arrCount[2]['option']=$post_array['option_3'];
    		$arrCount[2]['checked']=(array_key_exists('checked_3', $post_array))? 1 :0 ;
    	}
    	if(!empty($post_array['option_4'])){
    		$arrCount[3]['option']=$post_array['option_4'];
    		$arrCount[3]['checked']=(array_key_exists('checked_4', $post_array))? 1 :0 ;
    	}
    	if(!empty($post_array['option_5'])){
    		$arrCount[4]['option']=$post_array['option_5'];
    		$arrCount[4]['checked']=(array_key_exists('checked_5', $post_array))? 1 :0 ;
    	}
    	
 
    	if(!empty($arrCount)){
    		foreach ($arrCount as $key=>$data){
    			$dataArr['question_id']=$question_id;
    			$dataArr['answer']=$data['option'];
    			$dataArr['is_correct']=$data['checked'];
    				
    			$answerArr[$key]=$dataArr;
    		}
    		//bulk insertion to answers table
    		if($is_update==0){ //means insertion
    			$final_result=$this->db->insert_batch('answers', $answerArr);
    		}
    		else{ //updation
    			$this->db->delete('answers', array('question_id' => $question_id));
    			$final_result=$this->db->insert_batch('answers', $answerArr);
    			//$final_result=$this->db->update_batch('answers', $answerArr, 'answer');
    		
    		}
    	
    	}
    	}
    	if($post_array['type']=='TRUE/FALSE'){
    		$answer=($post_array['answer']==0)? 'FALSE' : 'TRUE';
    		$array = array('question_id' => $question_id, 'answer' => $answer, 'is_correct' => $post_array['answer']);
    		
    		
    		if($is_update==0){ //insertion
    			$this->db->set($array);
    			$this->db->insert('answers');
    		}
    		else{ //updation
    			$this->db->delete('answers', array('question_id' => $question_id));
    			$this->db->set($array);
    			$this->db->insert('answers');
    			
    			/* $this->db->delete('answers', array('question_id' => $question_id));
    			$this->db->insert('answers'); */
    		}
    		
    	}
    	
    }
    
    function update_answers($post_array,$question_id){
    	
    	$this->insert_answers($post_array,$question_id,1);
    }
    
    function delete_answers($question_id){
    	 
    	$this->db->delete('answers', array('question_id' => $question_id));
    }
    
    function get_answers_by_question_id($id){
    	$answersArr= array();
    	$dataArr=array();
    	$array = array('question_id' =>$id);
    	 $query = $this->db->get_where('answers', $array);
    	 $result=$query->result();
    	 if(!empty($result)){
    	 foreach ($result as $key=>$data) {
    	 	$dataArr['answer']=$data->answer;
    	 	$dataArr['is_correct']=$data->is_correct;
    	 	$answersArr['answers_arr'][$key]=$dataArr;
    	 	
    	 }
    	 return $answersArr;
    	 }
    }
    
    function get_answers_by_lecture($lecture_id){

        $query=$this->db->query("SELECT a.*
								FROM answers a
								INNER JOIN questions q ON a.question_id = q.id
								WHERE q.lecture_id =?;", array($lecture_id));

        $result=$query->result_array();
        return $result;

    }
}
/*
 $SQL_QUERY= */



