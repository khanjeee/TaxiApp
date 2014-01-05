

<div id="ajax_data"></div>
<form id="user_form" method="post" action="<?php echo site_url('admin/cabs/insert_assigned'); ?>" >
<div id="infoMessage"><h4 style="color:red;"><?php echo $status; ?></h4></div>
<div style="width: 100%;" class="flexigrid crud-form">	
<div class="mDiv">
		<div class="ftitle">
			<div class="ftitle-left">
				Select items to assign a driver to the cab	</div>			
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
Cabs :
</div>
				<div class="form-input-box" id="year_input_box">
					<?php echo $cabs; ?>
				</div>
				<div class="clear"></div>	
</div>


</div>
<div class="pDiv">	
      <div class="form-button-box">
				<input id="btn_submit" type="submit" value="Submit" class="btn btn-large"  >
	 </div>
</div> 

</div>
</div>
</form>
<script type="text/javascript">
$(document).ready(function () {

	$("form").submit(function () { 

		if($('#cab_id').val()>0   && $('#user_id').val()>0){
			return true;
			}
			else {
				alert("cab and driver must be selected ");
				return false ;
				}

			 });
	 

	 var cab_provider=$('#cab_provider_dd').val();
	 ajaxcall_driver(cab_provider); //populating driver dropdown on page load
	    
$('#cab_provider_dd').change(function(){ //any select change on the dropdown with id country trigger this code         
     var cab_provider= $('#cab_provider_dd').val();
    // alert(cab_provider);
    ajaxcall_driver(cab_provider); //populating driver dropdown onchange of cab provider
       
}); 
    
/*$('#user_id').change(function(){ //any select change on the dropdown with id country trigger this code         
    var user_id= $('#user_id').val();
    ajaxcall(user_id); //populating cab dropdown onchange of driver
   
}); */



function ajaxcall_driver(cab_provider_id){
	
	  $.ajax({
	        type: "POST",
	        url: "<?php echo site_url('admin/driver_information/get_driver_by_cab_provider_id'); ?>/"+cab_provider_id, //here we are calling our user controller and get_cities method with the country_id
	         
	        success: function(json) //we're calling the response json array 
	        {  
	            //alert(json);
	        	if(json.length>0){ 
	            obj = JSON.parse(json); //converting string to json obj
	        	$("#user_id > option").remove();
	          	 $.each(obj, function() {
	            	var opt = $('<option />'); // here we're creating a new select option with for each teacher
	               	opt.val(this.id);
	                opt.text(this.name);
					$('#user_id').append(opt);
	            	// console.log(this.id+'='+this.name);
	            	 
	            	});
	        	}
	        	else {
	        		$("#user_id > option").remove();
	        		var opt = $('<option />'); 
	               	opt.val('');
	                opt.text('None');
					$('#user_id').append(opt);
	            	}

	       // var user_id= $('#user_id').val();  
	      	 // alert(cab_provider_id);
	      	    ajaxcall(cab_provider_id);  //populating cab drop down with user id obtained from above ajax call

	        }
      
	         
	    });

	  
}




function ajaxcall(cab_provider_id){
	// alert(cab_provider_id);
$.ajax({
      type: "POST",
      url: "<?php echo site_url('admin/cabs/get_cabs_not_in_driver_information'); ?>/"+cab_provider_id, //here we are calling our user controller and get_cities method with the country_id
       
      success: function(json) //we're calling the response json array 
      {  // alert(json);
      	if(json.length>0){ 
          obj = JSON.parse(json); //converting string to json obj
      	$("#cab_id > option").remove();
        	 $.each(obj, function() {
          	var opt = $('<option />'); // here we're creating a new select option with for each teacher
             	opt.val(this.id);
              opt.text(this.cab_no);
				$('#cab_id').append(opt);
          	// console.log(this.id+'='+this.name);
          	 
          	});
      	}
      	else {
      		$("#cab_id > option").remove();
      		var opt = $('<option />'); 
             	opt.val('');
              opt.text('None');
				$('#cab_id').append(opt);
          	}


      }
       
  });
}

/*function ajaxcall(user_id){
	
	  $.ajax({
	        type: "POST",
	        url: "<?php //echo site_url('admin/cabs/get_cabs_by_driver_id'); ?>/"+user_id, //here we are calling our user controller and get_cities method with the country_id
	         
	        success: function(json) //we're calling the response json array 
	        {  
	        	if(json.length>0){ 
	            obj = JSON.parse(json); //converting string to json obj
	        	$("#cab_id > option").remove();
	          	 $.each(obj, function() {
	            	var opt = $('<option />'); // here we're creating a new select option with for each teacher
	               	opt.val(this.id);
	                opt.text(this.cab_no);
					$('#cab_id').append(opt);
	            	// console.log(this.id+'='+this.name);
	            	 
	            	});
	        	}
	        	else {
	        		$("#cab_id > option").remove();
	        		var opt = $('<option />'); 
	               	opt.val('');
	                opt.text('None');
					$('#cab_id').append(opt);
	            	}


	        }
	         
	    });
}*/


});


</script>
