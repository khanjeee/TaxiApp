<?php

class Years_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_years_dropdown($value)
    {   
    	$value=(!empty($value))? $value : 1;
    	$arrYears=array();
    	
    	$this->db->select('id,year');
     	$query = $this->db->get('years');
       
		foreach ($query->result() as $data ){
			
			$arrYears[$data->id]=$data->year;
		}
		
		return form_dropdown('year_id', $arrYears,$value , 'id="year_id"');
    }

    function get_studentsyear_dropdown($value)
    {
        $arrYears=array();
        $this->db->select('id,year');
        $this->db->where('id <=', $value);
        $query = $this->db->get('years');

        foreach ($query->result() as $data ){

            $arrYears[$data->id]=$data->year;
        }

        return form_dropdown('year_id', $arrYears,$value, 'id="year_id"');
    }


    function get_year_by_id($year_id)
    {
    	$query = $this->db->get_where('years', array('id' => $year_id));
    	$result=$query->result();
    	if(!empty($result)){
    	return $result[0]->year;
    	}
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
		
		return form_dropdown('batch_year', $dateArr,$value);
    }
    
    
   
		
}


