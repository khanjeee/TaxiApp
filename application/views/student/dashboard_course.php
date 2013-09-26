<div class="job-cat">
    <h1>Current Courses</h1>
    <?php
    if(count($courses) > 0)
    {
        echo '<ul>';
        foreach($courses as $item)
        {
    ?>
        <li><?php echo anchor('student/courses/view/'. $item['assign_course_id'],"[".$item['code']. "] ". $item['name']);?></li>
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
