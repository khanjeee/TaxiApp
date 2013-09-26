<div style="width: 100%;" class="flexigrid crud-form">	
<div class="mDiv">
		<div class="ftitle">
			<div class="ftitle-left">
				<?php //echo lang('forgot_password_heading');?>
				<?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?>
			</div>			
			<div class="clear"></div>
		</div>
		
</div>

<div id="main-table-box">
<?php echo form_open("authenticate/forgot_password");?>    	
 <div class="form-div">
      <div  class="form-field-box odd">
			<div  class="form-display-as-box">  
      	<?php echo sprintf(lang('forgot_password_email_label'), $identity_label);?>
      </div>
            <div class="form-input-box">
			<?php echo form_input($email);?>
			</div>
      </div>
      <?php if($message!=null) {?><div class="report-div error" id="report-error" style="display: block;"><?php echo $message; ?></div> <?php }?> 
</div>
<div class="pDiv">	
      <div class="form-button-box"><?php echo form_submit('submit', lang('forgot_password_submit_btn'),'class = "btn"');?></div>
</div>
 
<?php echo form_close();?>
</div>
</div>