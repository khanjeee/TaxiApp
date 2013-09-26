<script>
function submit(){
	 
var year_id=$("#year_id").val();	
var batch_years=$("#batch_years").val();
var sections=$("#sections").val();

window.location.href="<?php echo site_url('/admin/promote_students/view')?>/"+year_id+"/"+batch_years+"/"+sections;

}
</script>

<div id="infoMessage"><h1></h1></div>
<div style="width: 100%;" class="flexigrid crud-form">	
<div class="mDiv">
		<div class="ftitle">
			<div class="ftitle-left">
				Select students to be Promoted		</div>			
			<div class="clear"></div>
		</div>
		
</div>


<div id="main-table-box">
<div class="form-div">
<div class="form-field-box odd" >
<div class="form-display-as-box" >
Section :
</div>
				<div class="form-input-box" id="year_input_box">
					<?php echo $sections; ?>
				</div>
				<div class="clear"></div>	
</div>

<div class="form-field-box even" >
<div class="form-display-as-box" >
Batch :
</div>
				<div class="form-input-box" id="year_input_box">
					<?php echo $batch; ?>
				</div>
				<div class="clear"></div>	
</div>

<div class="form-field-box odd" >
<div class="form-display-as-box" >
Year :
</div>
				<div class="form-input-box" id="year_input_box">
					<?php echo $years; ?>
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


