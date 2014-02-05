<?php

class Payment_Model  extends CI_Model  {
    
	
 function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('form');
    }


   
    
    function get_total_trips() //returns total trips and their amount for last 7 days 
    {
    	$query = $this->db->query("SELECT COUNT(`amount`) AS 'total_trips', SUM(`amount`) AS 'total_amount' FROM `payment`
									WHERE CAST(`created` AS DATE) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()	");
    	$result=$query->result();
    	return  $result[0];
    	
    	
    }


    function get_total_trips_corporate($corporate_id) //returns total trips and their amount for last 7 days
    {
    	$query = $this->db->query("SELECT COUNT(p.amount) AS 'total_trips', SUM(p.amount) AS 'total_amount' FROM payment p
INNER JOIN journey_users j ON j.journey_id=p.journey_id
INNER JOIN users u ON u.id=j.user_id
WHERE CAST(p.created AS DATE) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE()
AND u.corporate_id={$corporate_id};");
    	$result=$query->result();
    	return  $result[0];
    	 
    	 
    }


}   
    
    
    
		



