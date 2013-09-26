<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irfan
 * Date: 9/16/13
 * Time: 12:13 AM
 * To change this template use File | Settings | File Templates.
 */
?>
<div class="job-detail"><h2>Assessment History</h2><br/><br/>
    <div>
        Courses <?php echo $courses; ?>
    </div>
    <div>
        Lectures <select id='lectures'>
                    </select>
    </div>
    <div class="submit-btn">
        <input type="button" value="Submit" id="btnSubmit" onclick="getHistory();">
    </div>
    <div id="history">
    </div>
</div>

<script>

    $(document).ready(function () {
        getLectures();

        $('#assign_course').change(function () {
            getLectures();
        });
    });

    function getLectures() {

        var assign_course_id = $('#assign_course').val();

        $.ajax({
            type:"POST",
            url:"<?php echo site_url('student/assestment/get_lectures'); ?>/" + assign_course_id,
            dataType:"json",
            success:function (data) {
                $('#lectures').empty();

                var lectures = data;
                if (lectures) {
                    $(lectures).each(function () {
                        $('#lectures').append("<option value='" + this['id'] + "'>" + this['topic'] + "</option>")
                    });
                }
            }
        });

    }

    function getHistory(){

        $('#history').empty();
        var lecture_id = $('#lectures').val();

        if(lecture_id){
            $.ajax({
                type:"POST",
                url:"<?php echo site_url('student/assestment/get_history'); ?>/" + lecture_id,
                dataType:"html",
                success:function (data) {
                    $('#history').html(data);
                }
            });
        }else {
            alert('Please select the lecture to get the results.');
        }

    }

</script>