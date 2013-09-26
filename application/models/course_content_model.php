<?php

class course_Content_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('url');
    }
    
 //returns content id else returns 0;
    function insert_content($post_array)
    { 
    	$data = array('file_path' => $post_array['content_id'],'content_type_id' => 2 ,
    					'created_by'=>$post_array['created_by'],'created_on'=>$post_array['created_on']);
    	$this->db->insert('content', $data);
    	$id=$this->db->insert_id();
    	return (!empty($id))? $id : 0 ;
    }
    
    function get_content_by_id($post_array){
    	
    	$query = $this->db->get_where('content', array('id' => $post_array['content_id']));
    	$result=$query->result();
    	if(!empty($result)){
    		return site_url(UPLOAD_LECTURES).'/'.$result[0]->file_path;
    	}
    }
		
}




