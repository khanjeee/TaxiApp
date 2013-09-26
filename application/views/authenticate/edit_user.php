<div id="infoMessage"><?php echo $message;?></div>
<div style="width: 100%;" class="flexigrid crud-form">	
<div class="mDiv">
		<div class="ftitle">
			<div class="ftitle-left">
				<?php echo lang('edit_user_heading');?>		</div>			
			<div class="clear"></div>
		</div>
		
	</div>

<div id="main-table-box">
<?php echo form_open(uri_string());?>

<div class="form-div">
      <div  class="form-field-box even">
			<div  class="form-display-as-box">      
            <?php echo lang('edit_user_fname_label', 'first_name');?> 
            </div>
            <div class="form-input-box">
            <?php echo form_input($first_name);?>
            </div>
      </div>
      
      <div class="form-field-box odd">
			<div  class="form-display-as-box"> 
             <?php echo lang('edit_user_lname_label', 'last_name');?>
            </div>
            <div  class="form-input-box">
            <?php echo form_input($last_name);?>
            </div>
      </div>
      
      

      <div class="form-field-box even">
			<div  class="form-display-as-box"> 
            <?php echo lang('create_user_company_label', 'company');?> 
             </div>
            <div  class="form-input-box">
            <?php echo form_input($company);?>
      		</div>
      </div>
      
    
       <div class="form-field-box odd">
			<div  class="form-display-as-box"> 
            <?php echo lang('edit_user_phone_label', 'phone');?>
             </div>
            <div  class="form-input-box">
           <?php echo form_input($phone);?>
      		</div>
      </div>
      <p>
             <br />
            
      </p>

       <div class="form-field-box even">
			<div  class="form-display-as-box"> 
           <?php echo lang('edit_user_password_label', 'password');?>
             </div>
            <div  class="form-input-box">
            <?php echo form_input($password);?>
      		</div>
      </div>
     
       <div class="form-field-box odd">
			<div  class="form-display-as-box"> 
        <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?>
             </div>
            <div  class="form-input-box">
            <?php echo form_input($password_confirm);?>
      		</div>
      </div>
      
	 <h3><?php echo lang('edit_user_groups_heading');?></h3>
	<?php foreach ($groups as $group):?>
	<label class="checkbox">
	<?php
		$gID=$group['id'];
		$checked = null;
		$item = null;
		foreach($currentGroups as $grp) {
			if ($gID == $grp->id) {
				$checked= ' checked="checked"';
			break;
			}
		}
	?>
	<input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
	<?php echo $group['name'];?>
	</label>
	<?php endforeach?>

      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>

      <?php if($message!=null) {?><div class="report-div error" id="report-error" style="display: block;"><?php echo $message; ?></div> <?php }?>
</div>

<div class="pDiv">	
      <div class="form-button-box"><?php echo form_submit('submit', lang('edit_user_submit_btn'),'class = "btn"');?></div>
     </div> 
<?php echo form_close();?>
</div>
</div>
