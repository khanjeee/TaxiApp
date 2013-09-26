<?php

function userdata( $key, $val = null ){
  $ci = &get_instance();
  if ( $val !== null ){
    $ci->session->set_userdata( $key, $val );
  } else {
    return $ci->session->userdata( $key );
  }
}

function debug($value,$die=false)
{
	echo '<pre>';
	if(is_array($value) || is_object($value))
			print_r($value);
	else
			echo $value;
	echo '</pre>';
	if($die==true)
			die;
}

function asset_url($uri)
{
	$CI =& get_instance();
	return $CI->config->base_url('assets/'.$uri);
}

function file_url($uri)
{
	$CI =& get_instance();
	return $CI->config->base_url('files/'.$uri);
}


//to generate an image tag, set tag to true. you can also put a string in tag to generate the alt tag
function asset_img($uri)
{
			return asset_url('img/'.$uri);
	
}



function asset_js($uri)
{
	
		return asset_url('js/'.$uri);
	
}

//you can fill the tag field in to spit out a link tag, setting tag to a string will fill in the media attribute
function asset_css($uri)
{
		
	return asset_url('css/'.$uri);
}

//to generate an image tag, set tag to true. you can also put a string in tag to generate the alt tag
function admin_asset_img($uri)
{
	
		return asset_url('admin/img/'.$uri);
	
	
}

function admin_asset_js($uri)
{
	
		return asset_url('admin/js/'.$uri);
	
}

//you can fill the tag field in to spit out a link tag, setting tag to a string will fill in the media attribute
function admin_asset_css($uri)
{
		
	return asset_url('admin/css/'.$uri);
}

function dateDiff($time1, $time2, $precision = 6) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }
 
    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }
 
    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    $diffs = array();
 
    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Set default diff to 0
      $diffs[$interval] = 0;
      // Create temp time from time1 and interval
      $ttime = strtotime("+1 " . $interval, $time1);
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
	$time1 = $ttime;
	$diffs[$interval]++;
	// Create new temp time from time1 and interval
	$ttime = strtotime("+1 " . $interval, $time1);
      }
    }
 
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
	break;
      }
      // Add value and interval 
      // if value is bigger than 0
      if ($value > 0) {
	// Add s if value is not 1
	if ($value != 1) {
	  $interval .= "s";
	}
	// Add value and interval to times array
	$times[] = $value . " " . $interval;
	$count++;
      }
    }
    
    array_pop($times);
    $time_string = implode(", ", $times);
    $time_string = str_replace(array('years','year'),'y',$time_string);
    $time_string = str_replace(array('months','month'),'m',$time_string);
    $time_string = str_replace(array('days','day'),'d',$time_string);
    $time_string = str_replace(array('hours','hour'),'h',$time_string);
    $time_string = str_replace(array('minutes','minute'),'min',$time_string);    
    $time_string = str_replace(array('days','day'),'d',$time_string);
    return $time_string;
    // Return string with times
    //return implode(", ", $times);
  }
