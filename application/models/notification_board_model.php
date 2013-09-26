<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irfan
 * Date: 8/3/13
 * Time: 11:04 PM
 * To change this template use File | Settings | File Templates.
 */

class Notification_Board_Model  extends CI_Model  {


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('form');
    }

    function get_notifications($section_id,$year_id, $count = 0){
        $limit = '';
        if($count!=0)
            $limit = 'LIMIT '. $count;

        $query = $this->db->query('SELECT nb.*
                                  FROM notification_board as nb
                                  WHERE
                                    nb.status = 1
                                    AND nb.section_id = ?
                                    AND nb.year_id = ?
                                    AND year(nb.created_on) = ?
                                  Order by nb.created_on DESC
                                  '. $limit, array($section_id,$year_id,date('Y')));

        $ret = $query->result_array();
        return $ret;
    }
}

?>