<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Taxi App Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('css/reset.css')?>" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('/css/text.css')?>" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('/css/grid.css')?>" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('/css/layout.css')?>" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('/css/nav.css')?>" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('/assets/grocery_crud/themes/flexigrid/css/flexigrid.css')?>" media="screen" />
    
    <!-- <link rel="stylesheet" type="text/css" href="<?php //echo site_url('/css/flexigrid.css')?>" media="screen" /> -->
    
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

<div class="container_12">
    <div class="grid_12 header-repeat">
        <div id="branding">
            <div class="floatleft">
                <img src="" alt="Logo" /></div>
            <div class="floatright">
                <div class="floatleft">
                    <img src="<?php echo site_url('/img/img-profile.jpg')?>" alt="Profile Pic" /></div>
                <div class="floatleft marginleft10">
                    <ul class="inline-ul floatleft">
                        <li>Hello Admin</li>
                        <li><a href="#">Config</a></li>
                        <li><a href="<?php echo site_url('admin/logout') ?>">Logout</a></li>
                    </ul>
                    <br />
                    <span class="small grey">Last Login: 3 hours ago</span>
                </div>
            </div>
            <div class="clear">
            </div>
        </div>
    </div>
    <div class="clear">

    </div>
    <div class="grid_12">
        <ul class="nav main">
            <li class="ic-gallery dd"><a href="<?php echo site_url('admin//users/view') ?>"><span>Users</span></a></li>
            <li class="ic-gallery dd"><a href="<?php echo site_url('admin/driver_information/view') ?>"><span>Driver</span></a></li>
            <li class="ic-gallery dd"><a href="<?php echo site_url('admin/corporate/view') ?>"><span>Corporate</span></a></li>
            <li class="ic-gallery dd"><a href="#"><span>Reports</span></a>
            	<ul>
                    <li ><a href="<?php echo site_url('admin/report/select_customer') ?>"><span>Customer</span></a></li>
                    <li ><a href="<?php echo site_url('admin/report/select_corporate') ?>"><span>Corporate</span></a></li>
                    
                </ul>
            
            </li>
           <li class="ic-gallery dd"><a href="<?php echo site_url('admin/check_in_stands/view') ?>"><span>Stands</span></a></li>
		</ul>
    </div>
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
        Copyright <a href="/">Taxi App</a>. All Rights Reserved.
    </p>
</div>
</body>
</html>



