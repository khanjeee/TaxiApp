function toogle_div()
{
	if(document.getElementById('branches').style.display == 'none')
	{
	    $("#up").show();
	    $("#down").hide();
	    $("#branches").fadeIn(100);
	}
    else
    {
	    $("#up").hide();
	    $("#down").show();
	    $("#branches").fadeOut(100);
	
	}

}

function show_recent_jobs()
{
    $('.resent-job-inner').show();
}

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validateZip(zip) {
   
   //var zip = document.getElementById('zipcode').value;
   //var zipRegExp = /(^\d{5}$)|(^\D{1}\d{1}\D{1}\s\d{1}\D{1}\d{1}$)/;
   //return zipRegExp.test(zip);
   var regexObj = {
	canada 		: /^[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ]( )?\d[ABCEGHJKLMNPRSTVWXYZ]\d$/i , //i for case-insensitive
	usa    		: /^\d{5}(-\d{4})?$/ 
};

    var regexp     = new RegExp(regexObj.canada);
		//var regexp = regexObj.canada;
		var resultStr  = ""; 
		// check for canada at first
		if( regexp.test(zip) ) {
			return true;
		} else {
			// now check for USA
			regexp = null;
			regexp = new RegExp(regexObj.usa);
			//regexp = regexObj.usa;
			if(regexp.test(zip)) {
				return true;
			} else {
				return false;
			}

		}
}

function check_search()
{
    if($('#keyword').val() == "")
        return false;
    else
        return true;    
}

function check_login()
{
    var identity = $('#identity').val();
    var password = $('#password').val();
    var count = 0;
    var error_msg = "";
    $('.input').css('border','1px solid #cccccc');
    
    if(identity == "")
    {
        $('#identity').css('border','1px solid red');
        error_msg += "Please provide email";
        count++;
    }
    if(validateEmail(identity) === false)
    {
        if(count == 0)
        {
            $('#identity').css('border','1px solid red');
            error_msg += "Please provide valid email";
            count++;
        }    
    }
    if(password == "")
    {
        $('#password').css('border','1px solid red');
        count++;
        if(count > 0)
            error_msg +="<br>";
            
        error_msg += "Please provide password";    
    }
    
    if(count == 0)
        return true;
    else
    {
        $('#signin_error').html(error_msg);
        return false;    
    }    
}

function log_click(url,ip_address,aid)
{
    $.ajax({
			  type: "POST",
			  url: "ajax/log_click",
			  data: { url: url, ip_address: ip_address, aid: aid }
			}).done(function( msg ) {
			  //console.log(msg);
			});
}

function change_type()
{
    var val = $("#type option:selected").val();
    if(val == 1)
    {
        $("#amount").hide();
        $("#dollar_sign").hide();   
    }
    else
    {
        $("#amount").show();
        $("#dollar_sign").show();   
    }
}
