
<div class="about-profile-people">
    <h1>Courses</h1>
    <div ><p>Year: <?php echo  $year; ?></p><br/><br/></div>
    <div id="courseList"></div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        getCourses();

    });
    $('#year_id').change(function(){
        getCourses();
    });

    function getCourses(){

        var year = $('#year_id').val();
        var section = $('#section_id').val();
        var student_id = $('#student_id').val();

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('student/courses/list_all'); ?>/"+ year + "/"+ section+ "/"+ student_id,
            dataType: "html",
            success: function(data) {
                $('#courseList').html(data);
            }
        })
    }


</script>