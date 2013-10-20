<script src="http://localhost/kmdc/assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.9.0.custom.min.js"></script>
<script src="http://www.kelvinluck.com/assets/jquery/datePicker/v2/demo/scripts/date.js"></script>
<script src="http://www.kelvinluck.com/assets/jquery/datePicker/v2/demo/scripts/jquery.datePicker.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="http://www.kelvinluck.com/assets/jquery/datePicker/v2/demo/styles/datePicker.css">

<script>
Date.format = 'yyyy-mm-dd';
$(function()
{
	$('.datepicker').datePicker({startDate:'2012-01-01'});
});

</script>

<div id="ajax_data"></div>
<form id="user_form" method="post" action="<?php echo site_url('admin/report/corporate_report'); ?>">
<div id="infoMessage"><h4 style="color:red;"></h4></div>
<div style="width: 100%;" class="flexigrid crud-form">	
<div class="mDiv">
		<div class="ftitle">
			<div class="ftitle-left">
				Select Corporate to generate Report	</div>			
			<div class="clear"></div>
		</div>
		
</div>


<div id="main-table-box">
<div class="form-div">
<div class="form-field-box odd" >
<div class="form-display-as-box" >
Corporate :
</div>
				<div class="form-input-box" id="year_input_box">
					<?php echo $corporate; ?>
				</div>
				<div class="clear"></div>	
</div>


<div class="form-field-box odd" >
<div class="form-display-as-box" >
From :
</div>
				<div class="form-input-box" id="year_input_box">
				<input name="start_date" id="date"  type="text" class="datepicker datepicker-input hasDatepicker" readonly="true" >	
				</div>
				<div class="clear"></div>	
</div>

<div class="form-field-box odd" >
<div class="form-display-as-box" >
To :
</div>
				<div class="form-input-box" id="year_input_box">
				<input name="end_date" id="date"  type="text" class="datepicker datepicker-input hasDatepicker" readonly="true" >	
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
</form>
<script type="text/javascript">


function submit(){
	$("#user_form").submit();	

}
</script>


<style>
a.dp-choose-date {
	float: left;
	width: 16px;
	height: 16px;
	padding: 0;
	margin: 5px 3px 0;
	display: block;
	text-indent: -2000px;
	overflow: hidden;
	background: url("<?php echo site_url('/assets/img/calendar.png')?>") no-repeat; 
}
a.dp-choose-date.dp-disabled {
	background-position: 0 -20px;
	cursor: default;
}
input.dp-applied {
	width: 140px;
	float: left;
}
</style>

