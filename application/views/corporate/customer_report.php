<?php
foreach($css_files as $file): ?>
<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<?php echo $output; ?>
<br>
<table>
<tr class="odd"><th>Total Amount</th>	<td><?php echo CURRENCY_UNIT. $payment_count; ?></td></tr>
<tr class="even"><th>Total Journeys</th>	<td><?php echo $journey_count; ?></td></tr>


			
</table>