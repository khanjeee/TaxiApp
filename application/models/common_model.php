<?php

class Common_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
  
    //generates dropdown for coming and past 3 years
    function get_batch_years_dropdown($value)
    {
    	
    	$date=(int)date("Y")+3;
		$lower_limit=(int)$date-6;
		
		$value=(!empty($value))? $value : date("Y");
		 
		$dateArr=array();
		for($a=$date;$a>=$lower_limit;$a--){
			
			$dateArr[$a]=$a;
		}
		
		return form_dropdown('batch_year', $dateArr,$value,'id="batch_years"');
    }
    
    function status_dropdown($value) {
    	$value=(!empty($value))? $value : 1;
    	$options = array(
    			'1'  => 'Active',
    			'2'    => 'Inactive',
    
    	);
    	return  form_dropdown('status', $options, $value);
    }
    
    function _status($value) {
    	return $value=($value==1)? 'Active' : 'Inactive';
    
    }
    
    function answer_type_dropdown($value){
    	    	
    	$value=(!empty($value))? $value : 'MCQ';
    	$options = array(
    			'MCQ'  => 'MCQ',
    			'TRUE/FALSE'    => 'TRUE/FALSE',
    	
    	);
    	return  form_dropdown('type', $options, $value,'id="field-type"');
    }
    
    //generates dropdown for coming and past 3 years
    function get_attendance_status($value)
    {
    	return ($value==1) ? 'Present' : 'Absent';
    
    }
		
}


