<?php if (!empty($_POST)) {   ?>
<div calss="DataTables_sort_wrapper">
<h2><strong>Search Criteria</strong><br>   
 
Employee id= <?php echo empty($_POST['employee_id'])? "Any" : $_POST['employee_id']; ?> ,
Journey Type= <?php echo ($_POST['journey_type']=="0")? "Any" : $_POST['journey_type']; ?> ,
File No= <?php echo empty($_POST['file_number'])? "Any" : $_POST['file_number']; ?>  ,
Start Date= <?php echo empty($_POST['start_date'])? "Any" : $_POST['start_date']; ?> ,
End Date= <?php echo empty($_POST['end_date'])? "Any" : $_POST['end_date']; ?> 
<h2>
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
<tr class="odd"><th>Total Amount</th>	<td><?php echo CURRENCY_UNIT.$payment_count; ?></td></tr>
<tr class="even"><th>Total Journeys</th>	<td><?php echo $journey_count; ?></td></tr>


			
</table>

