<?php 
//only allow to mark attendance till previous week
//getting date for a week earlier to allow calender insertion not more than a week earlier
$format = 'Y-m-d';
$date = date ( $format );
$startDate= date ($format, strtotime ( '-7 day' . $date ));
$endDate=date($format,time());
?>
<script src="http://localhost/kmdc/assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.9.0.custom.min.js"></script>
<script src="http://www.kelvinluck.com/assets/jquery/datePicker/v2/demo/scripts/date.js"></script>
<script src="http://www.kelvinluck.com/assets/jquery/datePicker/v2/demo/scripts/jquery.datePicker.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="http://www.kelvinluck.com/assets/jquery/datePicker/v2/demo/styles/datePicker.css">

<script>
Date.firstDayOfWeek = 0;
Date.format = 'yyyy-mm-dd';
$(function()
{
	$('.datepicker').datePicker({startDate:'<?php echo $startDate ; ?>',endDate:'<?php echo $endDate ; ?>'});
});
function submit(){
	var assigned_course=$("#assign_course").val();	
	var student_id=$("#student_id").val();
	var date=$("#date").val();
	

	window.location.href="<?php echo site_url('/admin/update_attendance/view')?>/"+student_id+"/"+assigned_course+"/"+date;
}
</script>



<div id="infoMessage"><h4 style="color:red;"><?php echo $status; ?></h4></div>
<div style="width: 100%;" class="flexigrid crud-form">	
<div class="mDiv">
		<div class="ftitle">
			<div class="ftitle-left">
				Select items to mark attendance		</div>			
			<div class="clear"></div>
		</div>
		
</div>


<div id="main-table-box">
<div class="form-div">
<div class="form-field-box odd" >
<div class="form-display-as-box" >
Section :
</div>
				<div class="form-input-box" id="year_input_box">
					<?php echo $sections; ?>
				</div>
				<div class="clear"></div>	
</div>


<div class="form-field-box odd" >
<div class="form-display-as-box" >
Course :
</div>
				<div class="form-input-box" id="year_input_box">
					<?php echo $assigned_course; ?>
				</div>
				<div class="clear"></div>	
</div>


<div class="form-field-box odd" >
<div class="form-display-as-box" >
Student ID :
</div>
				<div class="form-input-box" id="year_input_box">
				<input id="student_id"  type="text" maxlength="7" class=" datepicker-input hasDatepicker">	
				</div>
				<div class="clear"></div>	
</div>


<div class="form-field-box odd" >
<div class="form-display-as-box" >
Date :
</div>
				<div class="form-input-box" id="year_input_box">
				<input id="date"  type="text" class="datepicker datepicker-input hasDatepicker" disabled>	
				</div>
				<div class="clear"></div>	
</div>
</div>
<div class="pDiv">	
      <div class="form-button-box">
				<input type="submit" value="Submit" class="btn btn-large" onclick="submit();">
	 </div>
</div> 

</div>
</div>

<!--  -->





