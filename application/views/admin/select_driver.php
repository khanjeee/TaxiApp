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
<form id="user_form" method="post" action="<?php echo site_url('admin/report/driver_report'); ?>">
<div id="infoMessage"><h4 style="color:red;"></h4></div>
<div style="width: 100%;" class="flexigrid crud-form">	
<div class="mDiv">
		<div class="ftitle">
			<div class="ftitle-left">
				Select Driver to generate Report	</div>			
			<div class="clear"></div>
		</div>
		
</div>


<div id="main-table-box">
<div class="form-div">
<div class="form-field-box odd" >
<div class="form-display-as-box" >
Cab Provider :
</div>
				<div class="form-input-box" id="year_input_box">
					<?php echo $cab_provider; ?>
				</div>
				<div class="clear"></div>	
</div>
<div class="form-field-box odd" >
<div class="form-display-as-box" >
Driver :
</div>
				<div class="form-input-box" id="year_input_box">
					<?php echo $drivers; ?>
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
$(document).ready(function () {
					
	var cab_provider_id= $('#cab_provider_dd').val();
    ajaxcall(cab_provider_id);
$('#cab_provider_dd').change(function(){ //any select change on the dropdown with id country trigger this code         
	var cab_provider_id= $('#cab_provider_dd').val();
    ajaxcall(cab_provider_id);
   
}); 

function submit(){
	$("#user_form").submit();	

}

function ajaxcall(cab_provider_id){
	  $.ajax({
	        type: "POST",
	        url: "<?php echo site_url('admin/driver_information/get_driver_by_cab_provider_id'); ?>/"+cab_provider_id, //here we are calling our user controller and get_cities method with the country_id
	         
	        success: function(json) //we're calling the response json array 
	        {  
	            //alert(json);
	        	if(json.length>0){ 
	            obj = JSON.parse(json); //converting string to json obj
	        	$("#driver_dd > option").remove();
	          	 $.each(obj, function() {
	            	var opt = $('<option />'); // here we're creating a new select option with for each teacher
	               	opt.val(this.id);
	                opt.text(this.name);
					$('#driver_dd').append(opt);
	            	// console.log(this.id+'='+this.name);
	            	 
	            	});
	        	}
	        	else {
	        		$("#driver_dd > option").remove();
	        		var opt = $('<option />'); 
	               	opt.val('');
	                opt.text('None');
					$('#driver_dd').append(opt);
	            	}


	        }
	         
	    });
}

});
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

