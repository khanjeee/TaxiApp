<div style="width: 100%;" class="flexigrid crud-form">	
<div class="mDiv">
		<div class="ftitle">
			<div class="ftitle-left">
				<?php echo lang('edit_group_heading');?>	</div>			
			<div class="clear"></div>
		</div>
		
	</div>

<div id="main-table-box">

<?php echo form_open(current_url());?>
<div class="form-div">
      <div  class="form-field-box odd">
			<div  class="form-display-as-box">    
            <?php echo lang('create_group_name_label', 'group_name');?> 
            </div>
            <div class="form-input-box">
            <?php echo form_input($group_name);?>
      		</div>
      </div>

      <div  class="form-field-box even">
			<div  class="form-display-as-box">  
            <?php echo lang('edit_group_desc_label', 'description');?> 
            </div>
            <div class="form-input-box">
            <?php echo form_input($group_description);?>
      		</div>
      </div>
<?php if($message!=null) {?><div class="report-div error" id="report-error" style="display: block;"><?php echo $message; ?></div> <?php }?> 
</div>
     <div class="pDiv">	
      <div class="form-button-box"><?php echo form_submit('submit', lang('edit_group_submit_btn'),'class = "btn"');?></div>
     </div>

<?php echo form_close();?>
</div>
</div>