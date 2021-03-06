<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Taxi App Admin Panel</title>
<link rel="stylesheet" type="text/css"
	href="<?php echo site_url('css/reset.css')?>" media="screen" />
<link rel="stylesheet" type="text/css"
	href="<?php echo site_url('/css/text.css')?>" media="screen" />
<link rel="stylesheet" type="text/css"
	href="<?php echo site_url('/css/grid.css')?>" media="screen" />
<link rel="stylesheet" type="text/css"
	href="<?php echo site_url('/css/layout.css')?>" media="screen" />
<link rel="stylesheet" type="text/css"
	href="<?php echo site_url('/css/nav.css')?>" media="screen" />
<link rel="stylesheet" type="text/css"
	href="<?php echo site_url('/assets/grocery_crud/themes/flexigrid/css/flexigrid.css')?>"
	media="screen" />
<link rel="stylesheet" type="text/css"
	href="<?php echo site_url('/css/taxi_style.css')?>" media="screen" />


<!-- <link rel="stylesheet" type="text/css" href="<?php //echo site_url('/css/flexigrid.css')?>" media="screen" /> -->

<!--[if IE 6]><link rel="stylesheet" type="text/css" href="<?php echo site_url('/css/ie6.css')?>" media="screen" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?php echo site_url('/css/ie.css')?>" media="screen" /><![endif]-->
<!-- BEGIN: load jquery -->

<script src="<?php echo site_url('/js/jquery-1.8.2.min.js')?>"
	type="text/javascript"></script>
<script type="text/javascript"
	src="<?php echo site_url('/js/jquery-ui/jquery.ui.core.min.js')?>"></script>
<script
	src="<?php echo site_url('/js/jquery-ui/jquery.ui.widget.min.js')?>"
	type="text/javascript"></script>
<script
	src="<?php echo site_url('/js/jquery-ui/jquery.ui.accordion.min.js')?>"
	type="text/javascript"></script>
<script
	src="<?php echo site_url('/js/jquery-ui/jquery.effects.core.min.js')?>"
	type="text/javascript"></script>
<script
	src="<?php echo site_url('/js/jquery-ui/jquery.effects.slide.min.js')?>"
	type="text/javascript"></script>
<!-- END: load jquery -->
<script src="<?php echo site_url('/js/setup.js')?>"
	type="text/javascript"></script>
<script type="text/javascript">

        $(document).ready(function () {
            //setupDashboardChart('chart1');
            //setupLeftMenu();
            setSidebarHeight();


            $('#courses').change(function(){         
                var course_id= $('#courses').val();
                
                ajax_get_teachers_by_course(course_id);
                 
            });

			
            
            $('#markAll').change(function(){  
                var value=$(this).val();
					if(value==0){
							$(this).attr('value','1');
							$('.checked').attr('checked',true);
						}
					if(value==1){
							$(this).attr('value','0');
							$('.checked').attr('checked',false);
						}
		
            		 });
   		 
            
            
            <?php if(current_url()==site_url('admin/questions/topic_select')   ){ ?>

            var year_id=$('#year_id').val(); //get year id to populate courses and topic accordingly
            var course_id=$('#courses').val();
            	ajax_call_course(year_id);
           

            $('#year_id').change(function(){
    			        var yr=	$(this).val();
    			        ajax_call_course(yr);
    			}); 

             $('#assign_course').change(function(){
            	 var assign_course_id=	$(this).val();
            	 ajax_call_topic(assign_course_id);
    			}); 
           

            <?php } ?>
			//validation for editing whilst assign_course
			 <?php if(strrpos(current_url(), "admin/assign_course/view/edit"))   { ?>

			 var selected_section=$("#sections").val();
			 //var selected_teacher=$("#teachers_dd").val();
			// ajax_get_courses_by_section(selected_section);
			 //alert(selected_course); 
				
			 $('#sections').change(function(){  

				 var section_id=$(this).val();	
					 ajax_get_courses_by_section(section_id);

					 });

			 <?php } ?>
			
            <?php if(current_url()==site_url('admin/assign_course/view/add')   ){ ?>

			var section_id=$("#sections").val();

			 ajax_get_courses_by_section(section_id);
				
			 $('#sections').change(function(){  

			 var section_id=$(this).val();	
				 ajax_get_courses_by_section(section_id);

				// var courses=$("#courses").val();
			});

				 


			 

            <?php  } ?>
            

           
    			
     //check currents url is what we wanted 
  
            <?php if(current_url()==site_url('admin/course_lectures/view/add')  || current_url()==site_url('admin/course_assignments/view/add')  || current_url()==site_url('admin/attendance')){ ?>

        
        $('#batch_years,#sections').change(function(){          
            var batch_year= $('#batch_years').val();
            var section_id= $('#sections').val();

            //alert( section_id);
            
           $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/course_lectures/get_course_by_batch_section'); ?>",
                data: {batch_year: batch_year,section_id: section_id}, 
				success: function(json) //we're calling the response json array 
                {   
	              //  alert('<pre>'+json+'</pre>');
                	if(json.length>0){ 
                    obj = JSON.parse(json); //converting string to json obj
                	$("#assign_course > option").remove();
                  	 $.each(obj, function() {
                    	var opt = $('<option />'); // here we're creating a new select option with for each teacher
                       	opt.val(this.id);
                        opt.text(this.name);
						$('#assign_course').append(opt);
                    	// console.log(this.id+'='+this.name);
                    	 
                    	});
                	}
                	else {
                		$("#assign_course > option").remove();
                		var opt = $('<option />'); 
                       	opt.val('');
                        opt.text('None');
						$('#assign_course').append(opt);
                    	}


                }
                 
            }); 
             
        });

        <?php } ?>

		
        
        <?php 	$siteurl=site_url('admin/questions/view/edit'); 
        		$siteurl='*'.$siteurl.'*'; 
        		$currenturi=current_url(); $edit_url= (preg_match($siteurl,$currenturi));    ?>
        		
        <?php if(current_url()==site_url('admin/questions/view/add')  || $edit_url==1){ ?>

        var year_id=$('#year_id').val(); //get year id to populate courses and topic accordingly
        var course_id=$('#courses').val();
        	ajax_call_course(year_id);
       

        $('#year_id').change(function(){
			        var yr=	$(this).val();
			        ajax_call_course(yr);
			}); 

         $('#assign_course').change(function(){
        	 var assign_course_id=	$(this).val();
        	 ajax_call_topic(assign_course_id);
			}); 
    	
		 var html_question=<?php echo json_encode($this->load->view('static/questions_form.php', NULL, true)); ?>;
		 var html_true_false=<?php echo json_encode($this->load->view('static/true_false_form.php', NULL, true)); ?>;
				
	        $('#field-type').change(function(){ //any select change on the dropdown with id country trigger this code         

	        	  var type= $('#field-type').val();
	        	 
	        	  if(type=="MCQ"){
	        		  if ($('#answers_input_box').length==0){
	        		  var divv = $('<div id="answers_input_box" class="form-input-box"/>');  
	        		  
	        		  $('.pretty-radio-buttons').remove();
	        		  $('#answers_display_as_box').after(divv.append(html_question));

	        		  } }
	        	  if(type=="TRUE/FALSE"){
						$('#answers_input_box').remove();
						$('#answers_display_as_box').after(html_true_false);
		        	  }
        });
        
		
					
        <?php  }?>
			
    });
        
    function ajax_call_course(yr){
    	 $.ajax({
             type: "POST",
             url: "<?php echo site_url('admin/assign_course/get_assigned_courses_by_year'); ?>",
             data: {year_id: yr}, //here we are calling our user controller and passing year id to get courses accordingly
				success: function(json) //we're calling the response json array 
             {   
	                //alert('<pre>'+json+'</pre>');
             	if(json.length>0){ 
                 obj = JSON.parse(json); //converting string to json obj
             	$("#assign_course > option").remove();
               	 $.each(obj, function() {
                 	var opt = $('<option />'); // here we're creating a new select option with for each course
                    	opt.val(this.id);
                     opt.text(this.name);
						$('#assign_course').append(opt);
                 	// console.log(this.id+'='+this.name);
                 	 
                 	});
               	var assigned_courses_val=$('#assign_course').val()  ; //get assigned course selected on selection of year
               	if(assigned_courses_val>0){  
               		ajax_call_topic(assigned_courses_val);
               	}
             	}
             	else {
             		$("#assign_course > option").remove();
             		var opt = $('<option />'); 
                    	opt.val('');
                     opt.text('None');
						$('#assign_course').append(opt);


						$("#Topics > option").remove();
	               		var opt = $('<option />'); 
                    	opt.val('');
                     	opt.text('None');
						$('#Topics').append(opt);
                 	}

					
             }
              
         });

        }
    function ajax_call_topic(assigned_courses_val){
    	$.ajax({
             type: "POST",
             url: "<?php echo site_url('admin/course_lectures/get_topic_by_assignedcourseid'); ?>",
             data: {assign_course_id: assigned_courses_val}, //here we are calling our user controller and passing year id to get courses accordingly
				success: function(json) //we're calling the response json array 
             {   
	              //  alert('<pre>'+json+'</pre>');
             	if(json.length>0){ 
                 obj = JSON.parse(json); //converting string to json obj
             	$("#Topics > option").remove();
               	 $.each(obj, function() {
                 	var opt = $('<option />'); // here we're creating a new select option with for each course
                    	opt.val(this.id);
                     	opt.text(this.topic);
						$('#Topics').append(opt);
                 	// console.log(this.id+'='+this.name);
                 	 
                 	});
               	   	
             	}
             	else{
	               		$("#Topics > option").remove();
	               		var opt = $('<option />'); 
                   	opt.val('');
                    opt.text('None');
						$('#Topics').append(opt);

	               	}
             	 }
             	});	

        }

    function ajax_get_courses_by_section(section_id){

    	 $.ajax({
             type: "POST",
             url: "<?php echo site_url('admin/assign_course/get_courses_by_section'); ?>", //here we are calling our user controller and get_cities method with the country_id
             data: {section_id: section_id}, 
				success: function(json) //we're calling the response json array 
             {   
	              //  alert('<pre>'+json+'</pre>');
             	if(json.length>0){ 
                 obj = JSON.parse(json); //converting string to json obj
             	$("#courses > option").remove();
               	 $.each(obj, function() {
                 	var opt = $('<option />'); // here we're creating a new select option with for each teacher
                    	opt.val(this.id);
                    	/*if(this.id==21){
                    	opt.attr("selected","selected");	
                        	}*/
                     opt.text(this.name);
						$('#courses').append(opt);
                 	// console.log(this.id+'='+this.name);
                 	 
                 	});

               	var course_id=$('#courses').val()  ; //get assigned course selected on selection of year
               	if(course_id>0){  
               		///ajax_call_topic(assigned_courses_val);
               		ajax_get_teachers_by_course(course_id);

               	}
                	
             	}
             	else {
             		$("#courses > option").remove();
             		var opt = $('<option />'); 
                    	opt.val('');
                     opt.text('None');
						$('#courses').append(opt);

						ajax_get_teachers_by_course(0);
                 	}


             }
              
         }); 


        }

    function ajax_get_teachers_by_course(course_id){

    	$.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/teachers/get_teachers_by_course_id'); ?>/"+course_id, //here we are calling our user controller and get_cities method with the country_id
             
            success: function(json) //we're calling the response json array 
            {   
            	if(json.length>0){ 
                obj = JSON.parse(json); //converting string to json obj
            	$("#teachers_dd > option").remove();
              	 $.each(obj, function() {
                	var opt = $('<option />'); // here we're creating a new select option with for each teacher
                   	opt.val(this.id);
                    opt.text(this.name);
					$('#teachers_dd').append(opt);
                	// console.log(this.id+'='+this.name);
                	 
                	});
            	}
            	else {
            		$("#teachers_dd > option").remove();
            		var opt = $('<option />'); 
                   	opt.val('');
                    opt.text('None');
					$('#teachers_dd').append(opt);
                	}


            }
             
        }); 

        }
    </script>

</head>
<body>
	<!--- ====== Header ====== --->
	<header> <!--- Yellow Bar ---> <section class="yello_bar">
	<div class="admin">
		<div class="floatleft">
			<img src="<?php echo site_url('/img/img-profile.jpg')?>"
				alt="Profile Pic" />
		</div>
		<div class="floatleft marginleft10">
			<ul class="inline-ul floatleft">
				<li>Hello Admin</li>
				<li><a href="<?php echo site_url('admin/logout') ?>">Logout</a></li>
			</ul>
		</div>
	</div>
	</section> <!--- / Yellow Bar ---> <!--- Black Bar ---> <section
		class="black_bar">

	<div class="container">
		<!--- Logo --->
		<a href="#" class="logo"><img width="150"
			src="<?php echo site_url('/img/logo.png')?>" alt="Smart Taxi"> </a>
		<!--- / Logo --->

		<!--- Location --->
		<a class="location" href="#">Toronto</a>
		<!--- / Location --->


	</div>

	</section> <!--- / Black Bar ---> </header>
	<!--- ====== / Header ====== --->




	<div>
		<ul class="nav main">
           
            <li class="ic-gallery dd"><a href="#"><span>Reports</span></a>
            	<ul>
                    <li ><a href="<?php echo site_url('corporate/report/select_customer') ?>"><span>Individual employees</span></a></li>
                    <li ><a href="<?php echo site_url('corporate/report/select_corporate') ?>"><span>Advanced search</span></a></li>
                  
                    
                </ul>
                
            
            </li>
            <li ><a href="<?php echo site_url('corporate/users/view') ?>"><span>Users</span></a></li>                  
            
		</ul>
	</div>

	<div class="clear"></div>

	<div class="maincont">
		<?php echo $content; ?>
	</div>



	<div class="clear"></div>

	<!--- ====== Footer ====== --->
	<footer> <!--- White Bar ---> <section class="white_bar">
	<div class="container">
		<p class="copyrights">&copy; 2013 SmartTaxi - All Rights Reserved.</p>
		<ul class="social_icons">
			<li><a href="#"><img
					src="<?php echo site_url('/img')?>/facebook_icon.png"
					alt="Facebook"> </a></li>
			<li><a href="#"><img
					src="<?php echo site_url('/img')?>/twitter_icon.png" alt="Twitter">
			</a></li>
			<li><a href="#"><img
					src="<?php echo site_url('/img')?>/youtube_icon.png" alt="Youtube">
			</a></li>
		</ul>
	</div>
	</section> <!--- / White Bar ---> <!--- Grey Bar ---> <section
		class="grey_bar">
	<div class="container">
		<p>iPhone is a trademark of Apple Inc., registered in the U.S. and
			other countries. App Store is a service mark of Apple Inc.</p>
	</div>
	</section> </footer>
	<!--- ====== / Footer ====== --->
</body>
</html>



