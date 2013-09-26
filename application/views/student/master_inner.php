<?php $this->load->view('student/header',$header);?>
<div class="content">
<div class="wrapper">
<!-- detail Colum -->
<div class="detail-colum">
<?php echo $content;?>
</div>
<!-- detail Colum -->
<!-- Right Colum -->
<div class="right-col">

<?php echo $studentInfo; ?>

<div class="right-ad" style="margin-top:10px;"><img src="<?php echo asset_img('ad-banner.jpg');?>" /></div>
</div>
<!-- Right Colum -->

</div>
</div>
<?php $this->load->view('footer',$footer);?>
