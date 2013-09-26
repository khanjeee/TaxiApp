<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Dashboard | BlueWhale Admin</title>
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('css/reset.css')?>" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('/css/text.css')?>" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('/css/grid.css')?>" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('/css/layout.css')?>" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('/css/nav.css')?>" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/grocery_crud/themes/flexigrid/css/flexigrid.css')?>" media="screen" />
    
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo site_url('/css/flexigrid.css')?>" media="screen" /> -->
    
    <!--[if IE 6]><link rel="stylesheet" type="text/css" href="<?php echo site_url('/css/ie6.css')?>" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" type="text/css" href="<?php echo site_url('/css/ie.css')?>" media="screen" /><![endif]-->
    <!-- BEGIN: load jquery -->

    <script src="<?php echo site_url('/js/jquery-1.8.2.min.js')?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo site_url('/js/jquery-ui/jquery.ui.core.min.js')?>"></script>
    <script src="<?php echo site_url('/js/jquery-ui/jquery.ui.widget.min.js')?>" type="text/javascript"></script>
    <script src="<?php echo site_url('/js/jquery-ui/jquery.ui.accordion.min.js')?>" type="text/javascript"></script>
    <script src="<?php echo site_url('/js/jquery-ui/jquery.effects.core.min.js')?>" type="text/javascript"></script>
    <script src="<?php echo site_url('/js/jquery-ui/jquery.effects.slide.min.js')?>" type="text/javascript"></script>
    <!-- END: load jquery -->
    <script src="<?php echo site_url('/js/setup.js')?>" type="text/javascript"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            //setupDashboardChart('chart1');
            //setupLeftMenu();
            setSidebarHeight();

            $('#courses').change(function(){ //any select change on the dropdown with id country trigger this code         
                var course_id= $('#courses').val();
                
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
                 
            });
    			
     //check currents url is what we wanted 
            <?php if(current_url()==site_url('admin/course_lectures/view/add')){ ?>

        
        $('#batch_years,#sections').change(function(){ //any select change on the dropdown with id country trigger this code         
            var batch_year= $('#batch_years').val();
            var section_id= $('#sections').val();

           // alert(batch_year +'    ' +section_id);
            
           $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/course_lectures/get_course_by_batch_section'); ?>",
                data: {batch_year: batch_year,section_id: section_id}, //here we are calling our user controller and get_cities method with the country_id
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
        		$currenturi=current_url(); $edit_url= (preg_match($siteurl,$currenturi));   ?>
        		
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
    </script>
    
</head>
<body>

<div class="container_12">
    <div class="grid_12 header-repeat">
        <div id="branding">
            <div class="floatleft">
                <img src="<?php echo site_url('/img/kmdc_logo.png')?>" alt="Logo" /></div>
            <?php if ($is_logged_in){ ?>
            <div class="floatright">
                <div class="floatleft">
                    <img src="<?php echo site_url('/img/img-profile.jpg')?>" alt="Profile Pic" /></div>
                <div class="floatleft marginleft10">
                    <ul class="inline-ul floatleft">
                        <li>Hello Admin</li>
                        <li><a href="#">Config</a></li>
                        <li><a href="<?php echo site_url('authenticate/logout') ?>">Logout</a></li>
                    </ul>
                    <br />
                    <span class="small grey">Last Login: 3 hours ago</span>
                </div>
            </div>
            <?php } ?>
            <div class="clear">
            </div>
        </div>
    </div>
    <div class="clear">

    </div>
    <?php if ($is_logged_in){  //dispaly dashboard only if logged in ?>
    <div class="grid_12">
        <ul class="nav main">
            <li class="ic-dashboard"><a href="<?php echo site_url('admin/dashboard') ?>"><span>Dashboard</span></a> </li>
            <li class="ic-charts"><a href="<?php echo site_url('admin/courses/view') ?>"><span>Courses</span></a>
                <ul>
                    <li><a href="<?php echo site_url('admin/assign_course/view') ?>"><span>Assign Course</span></a></li>
                </ul>
            </li>
            <li class="ic-grid-tables"><a href="<?php echo site_url('admin/notifications/view') ?>"><span>Notification Board</span></a></li>
            <li class="ic-gallery dd"><a href="<?php echo site_url('admin/user_management') ?>"><span>User Management</span></a>
                <ul>
                    <li><a href="<?php echo site_url('admin/students/view') ?>"><span>Students</span></a></li>
                    <li><a href="<?php echo site_url('admin/teachers/view') ?>"><span>Teacher</span></a></li>
                </ul>
            </li>
            <li class="ic-gallery dd"><a href="<?php echo site_url('admin/departments/view') ?>"><span>Departments</span></a></li>
            <li class="ic-gallery dd"><a href="<?php echo site_url('admin/course_lectures/view') ?>"><span>Lectures</span></a>
                <ul>
                    <li ><a href="<?php echo site_url('admin/course_assignments/view') ?>"><span>Assignment</span></a></li>
                    <li ><a href="<?php echo site_url('admin/questions/topic_select') ?>"><span>Assessment</span></a></li>
                </ul>
            </li>
            <li class="ic-gallery dd"><a href="<?php echo site_url('admin/schedule/view') ?>"><span>Schedule</span></a></li>
            <li class="ic-gallery dd"><a href="<?php echo site_url('admin/promote_students/select') ?>"><span>Promote</span></a></li>
        </ul>
    </div>

    <?php  } ?>

    <div class="clear">
    </div>
 
    <div class="grid_12 content">
        <div class="box" style="margin-left: 0px">
            <div class="block">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
    
</div>
<div class="clear">
</div>
<div id="site_info">
    <p>
        Copyright <a href="/">KMDC</a>. All Rights Reserved.
    </p>
</div>
</body>
</html>



