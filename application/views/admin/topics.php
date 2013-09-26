<script>
function submit(){
	 
var topic_id=$("#Topics").val();	
if(topic_id>0){
window.location.href="<?php echo site_url('/admin/questions/view')?>/"+topic_id;
}
else{
	alert("No Topic selected");
}
}
</script>

<div id="infoMessage"><h1></h1></div>
<div style="width: 100%;" class="flexigrid crud-form">	
<div class="mDiv">
		<div class="ftitle">
			<div class="ftitle-left">
				Select Topic to see Assesment		</div>			
			<div class="clear"></div>
		</div>
		
</div>


<div id="main-table-box">
<div class="form-div">
<div class="form-field-box odd" >
<div class="form-display-as-box" >
Year :
</div>
				<div class="form-input-box" id="year_input_box">
					<?php echo $years; ?>
				</div>
				<div class="clear"></div>	
</div>

<div class="form-field-box even" >
<div class="form-display-as-box" >
Courses
</div>
				<div class="form-input-box" id="year_input_box">
					<?php echo $courses; ?>
				</div>
				<div class="clear"></div>	
</div>

<div class="form-field-box odd" >
<div class="form-display-as-box" >
Topic
</div>
				<div class="form-input-box" id="year_input_box">
					<?php echo $lectures; ?>
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




