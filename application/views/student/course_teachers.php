<div class="featured-jobs" style="margin-top:10px;">
    <h1>Course Teachers</h1>
    <?php
    foreach($course_assignments as $assignment)
    {
    ?>
    <ul>
        <li>
            <h1>Name</h1>
            <?php echo $assignment['name'];?>
        </li>
        <li>
            <h1>Designation</h1>
            <?php echo $assignment['designation'];?>
        </li>
        <li>
            <h1>Code</h1>
            <?php echo $assignment['teacher_id'];?>
        </li>
        <li>
            <h1>Email</h1>
            <?php echo $assignment['email'] ;?>
        </li>
        <li>
            <h1>Phone</h1>
            <?php echo $assignment['phone'];?>
        </li>
    </ul>
    <?php
    }
    ?>
</div>

        
        
