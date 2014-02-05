

<?php
foreach($css_files as $file): ?>
<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<?php echo $output; ?>


<script>
var group_id= $("#group_id").val();

if(group_id==5 || group_id==7){ //display corporates if corporate selected
	$("#corporate_id_field_box").show();
	$("#department_id_field_box").show();
	$("#cab_provider_field_box").hide();
	$("#lisence_no_field_box").hide();
	
    }
else if(group_id==6){
	$("#cab_provider_field_box").show();
	$("#lisence_no_field_box").show();
	$("#corporate_id_field_box").hide();
	$("#department_id_field_box").hide();
	$("#employee_id_field_box").hide();
	
	
}
else{
	$("#lisence_no_field_box").hide();
	$("#corporate_id_field_box").hide();
	$("#department_id_field_box").hide();
	$("#cab_provider_field_box").hide();
	$("#employee_id_field_box").hide();
	}
$("#group_id").change(function(){         
    var group_id= $("#group_id").val();
   
    if(group_id==5 || group_id==7){ //display corporates if corporate selected
    	$("#corporate_id_field_box").show();
    	$("#department_id_field_box").show();
    	$("#employee_id_field_box").show();
    	$("#cab_provider_field_box").hide();
    	$("#lisence_no_field_box").hide();
    	 }
    else if(group_id==6){
    	$("#lisence_no_field_box").show();
    	$("#cab_provider_field_box").show();
    	$("#corporate_id_field_box").hide();
    	$("#department_id_field_box").hide();
    	$("#employee_id_field_box").hide();
    	
    	
    }
    else{
    	$("#lisence_no_field_box").hide();
    	$("#corporate_id_field_box").hide();
    	$("#department_id_field_box").hide();
    	$("#cab_provider_field_box").hide();
    	$("#employee_id_field_box").hide();
    	}
     
});
</script>