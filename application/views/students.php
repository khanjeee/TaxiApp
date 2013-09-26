<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
<?php 
//foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php //echo $file; ?>" />
<?php //endforeach; ?>
<?php //foreach($js_files as $file): ?>
	<script src="<?php //echo $file; ?>"></script>
<?php //endforeach; ?>
<style type='text/css'>
body
{
	font-family: Arial;
	font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
	text-decoration: underline;
}
</style>
</head>
<body>

	<div style='height:20px;'></div>  
	<h1>Students Landing Page</h1>
    <div><h1>Welcome: <?php echo ucfirst($first_name); ?><h1>
    	</br>
	<a href="<?php echo site_url('authenticate/logout') ?>">Logout</a>
    </div>
</body>
</html>
