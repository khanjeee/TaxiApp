<?php

class Corporate_cab_provider_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('form');
    }
   
    



    //return 0 if insertion is successfull else return 1 
    /**
     * @first parameter:Post array
     * @2nd parameter :id of corporate
     * */
    function bulk_insert_corporate_cab_provider($post,$corporate_id)
    {
    	
    	$cabProviderArr=array();
    	$dataArr=array();
    	$postArr=$post['cab_provider_id'];

    	if(!empty($postArr)){
    		foreach ($postArr as $key=>$data){
    			$dataArr['cab_provider_id']=$data;
    			$dataArr['corporate_id']=$corporate_id;
    			    		
    			$cabProviderArr[$key]=$dataArr;
    		}
    			//bulk insertion to corporate_cab_provider table
    			 $final_result=$this->db->insert_batch('corporate_cab_provider', $cabProviderArr);
    			  
    			if($final_result){
    			
    			return 0;
    			} 
    		
    	}
    	else {
    		return 1 ;
    	}
    	
    		
    //	}
    	return 2 ; 
    		
    }
    
    
		
}


