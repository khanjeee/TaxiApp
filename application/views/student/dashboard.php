<div>
    <?php echo $schedule; ?>
    <?php echo $course; ?>
    <div class="job-cat">
        <h1>Notice</h1>
        <?php
        if(count($notifications) > 0)
        {
            echo '<ul>';
            foreach($notifications as $noticeItem)
            {
                $news =str_ireplace('<p>','',$noticeItem['news']);
                $news =str_ireplace('</p>','',$news);
        ?>
            <li>
                <?php echo $news.'( '.$noticeItem["created_on"].' )';?>
            </li>
        <?php
            }
            echo '</ul>';
        }
        else
        {
        ?>
        <div>No courses</div>
        <?php
        }
        ?>
    </div>
    
</div>
