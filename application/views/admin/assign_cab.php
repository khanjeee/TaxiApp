

<div id="ajax_data"></div>
<form id="user_form" method="post" action="<?php echo site_url('admin/cabs/insert_assigned'); ?>">
<div id="infoMessage"><h4 style="color:red;"><?php echo $status; ?></h4></div>
<div style="width: 100%;" class="flexigrid crud-form">	
<div class="mDiv">
		<div class="ftitle">
			<div class="ftitle-left">
				Select items to assign a driver to the cab	</div>			
			<div class="clear"></div>
		</div>
		
</div>


<div id="main-table-box">
<div class="form-div">

<div class="form-field-box odd" >
<div class="form-display-as-box" >
Driver :
</div>
				<div class="form-input-box" id="year_input_box">
					<?php echo $drivers; ?>
				</div>
				<div class="clear"></div>	
</div>

<div class="form-field-box odd" >
<div class="form-display-as-box" >
Cabs :
</div>
				<div class="form-input-box" id="year_input_box">
					<?php echo $cabs; ?>
				</div>
				<div class="clear"></div>	
</div>


</div>
<div class="pDiv">	
      <div class="form-button-box">
				<input type="submit" value="Submit" class="btn btn-large">
	 </div>
</div> 

</div>
</div>
</form>
