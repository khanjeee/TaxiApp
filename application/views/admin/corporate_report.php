<?php
foreach($css_files as $file): ?>
<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<tr id="row-6" class="odd">
							<td class=" ">Total Payment</td>
							<td class=" "><?php echo $payment_count; ?></td>
						
</tr>
<?php echo $output; ?>

