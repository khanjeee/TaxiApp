<?php
class Corporate_report extends grocery_CRUD_Model
{
//The function get_list is just a copy-paste from grocery_CRUD_Model
	function get_list()
	{
		$corporate_id=(isset($_POST['corporate_id']))? $_POST['corporate_id'] : -1;	
		$start_date=(isset($_POST['start_date']))? $_POST['start_date'] : NULL;	
		$end_date=(isset($_POST['end_date']))? $_POST['end_date'] : NULL;	
		//print_r($_POST); die;
	 if($this->table_name === null)
	  return false;
	
	 $select = "{$this->table_name}.*,payment.*,journey_users.*,driver_information.name as 'driver_name'";
	
  // ADD YOUR SELECT FROM JOIN HERE, for example: <------------------------------------------------------
  // $select .= ", user_log.created_date, user_log.update_date";

	 if(!empty($this->relation))
	  foreach($this->relation as $relation)
	  {
	   list($field_name , $related_table , $related_field_title) = $relation;
	   $unique_join_name = $this->_unique_join_name($field_name);
	   $unique_field_name = $this->_unique_field_name($field_name);
	  
	if(strstr($related_field_title,'{'))
		$select .= ", CONCAT('".str_replace(array('{','}'),array("',COALESCE({$unique_join_name}.",", ''),'"),str_replace("'","\\'",$related_field_title))."') as $unique_field_name";
	   else	  
		$select .= ", $unique_join_name.$related_field_title as $unique_field_name";
	  
	   if($this->field_exists($related_field_title))
		$select .= ", {$this->table_name}.$related_field_title as '{$this->table_name}.$related_field_title'";
	  }
	
	 $this->db->select($select, false);
	
  // ADD YOUR JOIN HERE for example: <------------------------------------------------------
 //  $this->db->join('user_log','user_log.user_id = users.id');
   $this->db->join('payment','payment.customer_id = '. $this->table_name . '.id'); //$this->table_name is users table passsed from crud
   $this->db->join('journey_users','journey_users.journey_id = payment.journey_id');
   $this->db->join('journeys','journeys.id = journey_users.journey_id');
   $this->db->join('driver_information','driver_information.cab_id = journeys.cab_id');
   $this->db->where('users.corporate_id',$corporate_id);
   if(!empty($start_date)){
   $this->db->where('payment.created >=',$start_date.' 00:00:00'); //00:00:00 appended to select items from start of day
   }   
   if(!empty($end_date)){
   	$this->db->where('payment.created <=',$end_date.' 23:59:59'); //23:59:59 appended to select items till the end of day
   }
   $this->db->order_by("pickup_time", "desc");
    
	 $results = $this->db->get($this->table_name)->result();
	
	 return $results;
	}
}