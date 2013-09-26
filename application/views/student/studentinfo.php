<div class="featured-jobs">
        <h1>Student Profile</h1>
                <ul style="float:left;width:160px;">
            <li style="float:left;">
                <span style="height:60px;width:80px;"><img src="<?php echo asset_img('student_male.png');?>" /></span>
                Batch <?php echo $student['batch_year'];?>
                <?php echo $student['section'];?>
            </li>
        </ul>
    <ul>
        <li>
            <h1>Name</h1>
            <?php echo $student['name'];?>
        </li>
        <li>
            <h1>Role #</h1>
            <?php echo $student['role_number'];?>
        </li>
        <li>
            <h1>Email</h1>
            <?php echo $student['email'];?>
        </li>
        <li>
            <h1>DOB</h1>
            <?php echo date('d-M-Y',strtotime($student['dob'])) ;?>
        </li>
        <li>
            <h1>Section</h1>
            <?php echo $student['section'];?>
            <input type="hidden" id="section_id" value="<?php echo $student['section_id'];?>">
        </li>
        <li>
            <h1>Session</h1>
            <?php echo $student['year'];?>
            <input type="hidden" id="year_id" value="<?php echo $student['year_id'];?>">
        </li>
        <li>
            <h1>Batch</h1>
            <?php echo $student['batch_year'];?>
            <input type="hidden" id="batch_year" value="<?php echo $student['batch_year'];?>">
            <input type="hidden" id="student_id" value="<?php echo $student['id'];?>">
        </li>
    </ul>
</div>


