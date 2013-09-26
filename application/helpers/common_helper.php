<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('test_method'))
{
    function Dropdown_years($var = '')
    {
    	$CI =& get_instance();
    	
    	$CI->load->helper('form');
    	$CI->load->model('Years_Model','years');
    	
    	return  form_dropdown('year_id', $CI->years->get_years_dropdown(''));
       
    }   
    
    
    function pr($data = '')
    {
    	echo '<pre>'; print_r($data); echo'</pre>';
    	 
    }
    
}