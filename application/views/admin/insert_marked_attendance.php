<?php
foreach($css_files as $file): ?>
<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<script>

</script>

<form action="<?php   echo site_url('admin/attendance/insert'); ?>" method="post" >
<input type="hidden" name="assign_course_id" value="<?php echo $this->uri->segment(4); ?>">
<input type="hidden" name="date" value="<?php echo $this->uri->segment(7); ?>">
<input type="submit" value="Submit Attendance" >
<label>Mark All<input type="checkbox" id="markAll" value="0"></label>
<?php echo $output; ?>

</form>
