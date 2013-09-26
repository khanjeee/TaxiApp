<?php  $column_width = (int)(80/count((array)$users)); ?>

<div id="infoMessage"><?php echo $message;?></div>
<div class="flexigrid" style="width: 100%;">
<div class="bDiv">
<div><h1><?php echo lang('index_heading');?> </h1></div>
<div class="fbutton"><div>
						<span class="add"><?php echo anchor('authenticate/create_user', lang('index_create_user_link'))?>  </span>
						<span class="add"> <?php echo anchor('authenticate/create_group', lang('index_create_group_link'))?></span>	
					</div>
</div>
<table id="flex1" cellspacing="0" cellpadding="0" border="0" >
	<thead>
	<tr  class="hDiv">
		<th width='<?php echo $column_width?>%'> <div class="text-left field-sorting "> <?php echo lang('index_fname_th');?> </div></th>
		<th width='<?php echo $column_width?>%'><div class="text-left field-sorting "><?php echo lang('index_lname_th');?></div></th>
		<th width='<?php echo $column_width?>%'><div class="text-left field-sorting "><?php echo lang('index_email_th');?></div></th>
		<th width='<?php echo $column_width?>%'><div class="text-left field-sorting "><?php echo lang('index_groups_th');?></div></th>
		<th width='<?php echo $column_width?>%'><div class="text-left field-sorting "><?php echo lang('index_status_th');?></div></th>
		<th width='<?php echo $column_width?>%'><div class="text-left field-sorting "><?php echo lang('index_action_th');?></div></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($users as $key=>$user):?>
		<tr <?php if($key % 2 == 1){?>class="erow"<?php }?>>
			<td width='<?php echo $column_width?>%'><div class='text-left'><?php echo $user->first_name;?></div></td>
			<td width='<?php echo $column_width?>%'><div class='text-left'><?php echo $user->last_name;?></div></td>
			<td width='<?php echo $column_width?>%'><div class='text-left'><?php echo $user->email;?></div></td>
			<td width='<?php echo $column_width?>%'><div class='text-left'>
				<?php foreach ($user->groups as $group):?>
					<?php echo anchor("authenticate/edit_group/".$group->id, $group->name) ;?><br />
                <?php endforeach?></div>
			</td>
			<td width='<?php echo $column_width?>%'><div class='text-left'><?php echo ($user->active) ? anchor("authenticate/deactivate/".$user->id, lang('index_active_link')) : anchor("authenticate/activate/". $user->id, lang('index_inactive_link'));?></div></td>
			<td width='<?php echo $column_width?>%'><div class='text-left'><?php echo anchor("authenticate/edit_user/".$user->id, '<span class=\'edit-icon\'></span>') ;?></div></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
</div>
</div>
<p><?php //echo anchor('authenticate/create_user', lang('index_create_user_link'))?> <?php //echo anchor('authenticate/create_group', lang('index_create_group_link'))?></p>
