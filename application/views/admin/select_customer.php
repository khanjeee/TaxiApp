<div id="ajax_data"></div>
<form id="user_form" method="post" action="<?php echo site_url('admin/report/customer_report'); ?>">
<div id="infoMessage"><h4 style="color:red;"></h4></div>
<div style="width: 100%;" class="flexigrid crud-form">	
<div class="mDiv">
		<div class="ftitle">
			<div class="ftitle-left">
				Select Customer to generate Report	</div>			
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
Customer :
</div>
				<div class="form-input-box" id="year_input_box">
					<?php echo $users; ?>
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

	var corporate_id= $('#corporate_id').val();
    ajaxcall(corporate_id);
$('#corporate_id').change(function(){ //any select change on the dropdown with id country trigger this code         
    var corporate_id= $('#corporate_id').val();
    ajaxcall(corporate_id);
   
}); 

function submit(){
	$("#user_form").submit();	

}
function ajaxcall(corporate_id){
	  $.ajax({
	        type: "POST",
	        url: "<?php echo site_url('admin/users/get_corporate_users'); ?>/"+corporate_id, //here we are calling our user controller and get_cities method with the country_id
	         
	        success: function(json) //we're calling the response json array 
	        {  
	            //alert(json);
	        	if(json.length>0){ 
	            obj = JSON.parse(json); //converting string to json obj
	        	$("#user_id > option").remove();
	          	 $.each(obj, function() {
	            	var opt = $('<option />'); // here we're creating a new select option with for each teacher
	               	opt.val(this.id);
	                opt.text(this.first_name);
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


	        }
	         
	    });
}

});
</script>




