<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>KMDC Student Portal</title>
<script src="<?php echo asset_js('jquery1.7-min.js');?>" type="text/javascript"></script>
<script src="<?php echo asset_js('jquery-ui.js');?>" type="text/javascript"></script>


<script src="<?php echo asset_js('common.js');?>" type="text/javascript"></script>
<link href="<?php echo asset_css('style1.css');?>" rel="stylesheet" type="text/css" />

<link href="<?php echo asset_css('jquery-ui.css');?>" rel="stylesheet" type="text/css" />

</head>

<body>
<div class="top-bar">
<div class="wrapper">

<div class="top-profile-box">
<div class="thumb"><img src="<?php echo asset_img("top-profile-img.jpg");?>" alt="image" /></div>
<h1><?php echo ucfirst($user->first_name);?></h1>
<div class="top-set-icon" onclick="toogle_div();"><img src="<?php echo asset_img("setting-icon.jpg");?>" alt="setting" /></div>
<div class="top-set-menu" id="branches" style="display:none;">
<div class="tooltip-arrow"></div>
<ul>
<!--<li class="hd">Use Cymango as:</li>
<li><a href="#" class="selected">Buyer of Services</a></li>
<li class="btm-brd"><a href="#">Services Provider</a></li>-->

<!--<li class="btm-brd"><a href="--><?php //echo base_url();?><!--contact/advertise">Advertise</a></li>-->
    <!--<li class="btm-brd"><a href="--><?php //echo base_url();?><!--home/profile_edit">Account Setting</a></li>-->



<li class="btm-brd"><a href="<?php echo base_url();?>student/dashboard/profile/edit/<?php echo $header['student_id'];?>">Profile</a></li>
<li class="btm-brd"><a href="<?php echo base_url();?>student/dashboard">Dashboard</a></li>

<li><a href="<?php echo base_url();?>authenticate/logout">Logout</a></li>
</ul>
</div>
</div>


</div>
</div>
<div class="logo-bar">
<div class="wrapper">
<div class="logo"><a href="<?php echo base_url();?>"><img src="<?php echo asset_img("kmdc_logo.png");?>" alt="cymango" border="0" /></a></div>
<!--<div class="top-ad"><img src="<?php echo asset_img("top-banner.jpg");?>" alt="Top Banner" /></div>-->
</div>
</div>
<?php $this->load->view('student/links');?>
