<?php if (!empty($_POST)) { ?>
<div class="DataTables_sort_wrapper">
<h2>
<strong>Search Criteria</strong><br>      
Customer= <?php echo empty($_POST['user'])? "Any" : $_POST['user']; ?> ,
Start Date= <?php echo empty($_POST['start_date'])? "Any" : $_POST['start_date']; ?> ,
End Date= <?php echo empty($_POST['end_date'])? "Any" : $_POST['end_date']; ?> 
</h2>
</div>
<?php }  ?>
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