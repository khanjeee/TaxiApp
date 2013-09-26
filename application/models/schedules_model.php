<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irfan
 * Date: 7/28/13
 * Time: 1:41 PM
 * To change this template use File | Settings | File Templates.
 */

class Schedules_Model  extends CI_Model  {


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('form');
    }

    function get_schedules($start,$end){

        $query = $this->db->query('SELECT s.*,c.code,c.name as course_name
                                  FROM schedules as s
                                  INNER JOIN assign_course as ac on s.assign_course_id = ac.id
                                  INNER JOIN courses as c on c.id = ac.course_id
                                  WHERE s.start_on > ? AND s.end_on < ?
                                  ', array($start, $end));

        $ret = $query->result_array();
        return $ret;
    }

    function get_schedulesByYear($year){
        $query = $this->db->query('SELECT s.*,c.code,c.name as course_name
                                  FROM schedules as s
                                  INNER JOIN assign_course as ac on s.assign_course_id = ac.id
                                  INNER JOIN courses as c on c.id = ac.course_id
                                  WHERE ac.batch_year = ?
                                  GROUP BY s.day,s.start_on
                                  ', array($year));
        $ret = $query->result_array();
        return $ret;
    }
}


?>