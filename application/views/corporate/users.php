

<?php
foreach($css_files as $file): ?>
<link
	type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<?php echo $output; ?>





<script type="text/javascript">

    function send_email(email,first_name,last_name,qr_url){
		
    	var r=confirm("Are you sure you want to send message to the "+email);
    	if (r==true)
    	  {
    		ajax_call_email(email,first_name,last_name,qr_url);
    	 
    	  }
    	else
    	  {
    	  return ;
    	  }
    }
 
  	  function ajax_call_email(email,first_name,last_name,qr_url){
    	  $.ajax({
    	        type: "POST",
    	        url: "<?php echo site_url('corporate/users/email_user_info'); ?>/", //here we are calling our user controller and get_cities method with the country_id
    	        data: { 'email': email ,'first_name': first_name, 'last_name': last_name, 'qr_url' :qr_url },
    	        success: function(successMessage) {  
        	        alert(successMessage);
        	        },
    	  		error: function(XMLHttpRequest, textStatus, errorThrown) { 
    	         alert("Error: " + errorThrown); 
    	    }       
    	         
    	    });  
    }




</script>
