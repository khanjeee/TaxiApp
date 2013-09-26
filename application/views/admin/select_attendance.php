<!-- 
<script src="http://localhost/kmdc/assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.9.0.custom.min.js"></script>
<script src="http://www.kelvinluck.com/assets/jquery/datePicker/v2/demo/scripts/date.js"></script>
<script src="http://www.kelvinluck.com/assets/jquery/datePicker/v2/demo/scripts/jquery.datePicker.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="http://www.kelvinluck.com/assets/jquery/datePicker/v2/demo/styles/datePicker.css">
 -->
<script type="text/javascript">
/*function dp(){
$('.datepicker-input').datepicker({
dateFormat: 'yyyy-mm-dd',
showButtonPanel: true,
changeMonth: true,
changeYear: true
});

}*/
/*
Date.firstDayOfWeek = 0;
Date.format = 'yyyy/mm/dd';
$(function()
{
	$('.datepicker').datePicker()
});*/
</script>
<script>
function submit(){
	var assigned_course=$("#assign_course").val();	
	var batch_years=$("#batch_years").val();
	var sections=$("#sections").val();
	var date="<?php echo $calendar; ?>";
	
    $.ajax({
        type: "POST",
        url: "<?php echo site_url('admin/attendance/check_attendance'); ?>",
        data: {assign_course_id: assigned_course,date: date}, 
		success: function(json) //we're calling the response json array 
        {   
			
		if(json==1)
			window.location.href="<?php echo site_url('/admin/attendance/view')?>/"+assigned_course+"/"+batch_years+"/"+sections+"/"+date;
		else
			alert("Attendance already marked");

	        }
         
    }); 

	


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

<div class="form-field-box even" >
<div class="form-display-as-box" >
Batch :
</div>
				<div class="form-input-box" id="year_input_box">
					<?php echo $batch; ?>
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
Date :
</div>
				<div class="form-input-box" id="year_input_box">
					<?php echo $calendar; ?>
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

<!-- <input  type="text" class="datepicker" maxlength="10" value="" name="lecture_date" id="field-lecture_date"> -->





