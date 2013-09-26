<script>

    function getLectures(){

        var tag = $('#ddl_tags').val()
        var assignment_course_id = <?= $course_assignment_id; ?>;

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('student/courses/get_lectures'); ?>/"+ tag + "/"+ assignment_course_id ,
            dataType: "html",
            success: function(data) {
                $('#lecture_list').html(data);
            }
        })
    }
</script>

<div class="job-detail">
<div class="box-fold"></div>

<h1><?php echo $course->name;?></h1>
<div class="detail">
<div class="info">
<span class="posted">Code: <?php echo $course->code;?></span>
<span class="time">Year: <?php echo $course->year;?></span>
<span class="price">Section: <?php echo $course->section;?></span>
</div>
<p><?php echo $course->description;?></p>
</div>

</div>


<div class="about-profile-people">
    <h1>Lectures</h1>
    <?php
    if(!empty($lectures)){
        $html = "<div class='filter'>Filter using tag:<select id='ddl_tags' onchange='getLectures();'>".
                "<option value='all'>All</option>";
            foreach($lectures as $lecture) {
                $html .= "<option value='". $lecture->tags ."'>". $lecture->tags ."</option>";
            }
            $html .= "</select><br/><br>";

            echo $html . "</div>";
        }
        ?>
    <div id='lecture_list'>
    <?php echo $lecture_list;?>
    </div>
</div>
