<?php

class Sections_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('form');
    }
    /*value parameter is passed when the function is called on edit form*/
    function get_sections_dropdown($value)
    {   
    	
    	$value=(!empty($value))? $value : 1;
    	$arrSections=array();
    	
    	$this->db->select('id,section');
     	$query = $this->db->get('sections');
       
		foreach ($query->result() as $data ){
			
			$arrSections[$data->id]=$data->section;
		}
		
		return form_dropdown('section_id', $arrSections,$value,'id="sections"');
    }
    
    
    function get_section_by_id($section_id)
    {
    	$query = $this->db->get_where('sections', array('id' => $section_id));
    	$result=$query->result();
    	if(!empty($result)){
    	return $result[0]->section;
    	}
    }
    
    
		
}


