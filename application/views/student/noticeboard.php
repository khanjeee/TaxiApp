<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irfan
 * Date: 8/1/13
 * Time: 6:29 AM
 * To change this template use File | Settings | File Templates.
 */
?>
<div class="job-detail">
<h2>Notice Board</h2>
<div id="noticeboard">
    <?php
    if(count($notifications)==0){
        echo "<div class='notice'> No notice available.</div>";
    }

    foreach($notifications as $noticeItem){
    ?>
    <div class="notice detail">
        <div class="notice-header box-header" style="float: left;">
            <div class="notice-title">
                <?= $noticeItem['news']; ?>
            </div>
            <div class="notice-date">
                <b>Date:</b> <?php echo date('D, d M Y H:i', strtotime($noticeItem['created_on'])); ?>
            </div>
        </div>
        <div class="clear"></div>
        <div class="notice-body">
            <div class="notice-desc">
                <?php echo $noticeItem['news_desc']; ?>
            </div>
        </div>
    </div>
    <?php } ?>

</div>
</div>