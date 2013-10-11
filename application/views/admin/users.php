

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

if(group_id==5){ //display corporates if corporate selected
	$("#corporate_id_field_box").show();
    }
else{
	$("#corporate_id_field_box").hide();
	}
$("#group_id").change(function(){         
    var group_id= $("#group_id").val();
   
    if(group_id==5){ //display corporates if corporate selected
    	$("#corporate_id_field_box").show();
        }
    else{
    	$("#corporate_id_field_box").hide();
    	}
     
});
</script>