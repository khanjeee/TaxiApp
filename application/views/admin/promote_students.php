<?php
foreach($css_files as $file): ?>
<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<script>

</script>
<form action="<?php echo site_url('admin/promote_students/update'); ?>" method="post" >
<input type="hidden" name="year_id" value="<?php echo $this->uri->segment(4); ?>">
<input type="submit" value="Promote" >
<label>Mark All<input type="checkbox" id="markAll" value="0"></label>
<?php echo $output; ?>

</form>
