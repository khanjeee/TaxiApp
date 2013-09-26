<?php
//$html = "<table id='lecture' class='border_table'>".
//    "<tr><td style='width:200px'>Topic</td><td style='width:80px'>Lecture Date</td><td style='width:40px'>PPT</td><td style='width:40px'>Audio</td><td>Detail</td></tr>";
//
//if(!empty($lectures)){
//    foreach($lectures as $lecture) {
//        $lec_file = "";
//        if(!empty($lecture->uploaded_file)) {
//            $lec_file = "<a href='".site_url(UPLOAD_LECTURES_FILE.'/'. $lecture->uploaded_file)."'>". $lecture->uploaded_file ."</a>";
//        }
//        $lec_audiofile = "";
//        if(!empty($lecture->uploaded_audio)){
//            $lec_audiofile = "<a href='".site_url(UPLOAD_LECTURES_AUDIO.'/'. $lecture->uploaded_audio)."'>". $lecture->uploaded_audio ."</a>";
//        }
//
//        $html .= "<tr>".
//            "<td style='width:200px'>". $lecture->topic ."</td>".
//            "<td style='width:80px'>". $lecture->lecture_date ."</td>".
//            "<td style='width:40px'>". $lec_file ."</td>".
//            "<td style='width:40px'>". $lec_audiofile ."</td>".
//            "<td>". anchor('student/courses/lecture/'. $lecture->id , 'click here') ."</td>".
//            "</tr>";
//    }
//}else{
//    $html .= "<tr><td colspan='5'> No lectures uploaded</td></tr>";
//}
//
//$html .= "</table>";
//
//echo $html;
//?>


<?php
if(!empty($lectures)){


foreach($lectures as $lecture)
{
    $lec_file = "";
    if(!empty($lecture->uploaded_file)) {
        $lec_file = "<a href='".site_url(UPLOAD_LECTURES_FILE.'/'. $lecture->uploaded_file)."'>". $lecture->uploaded_file ."</a>";
    }
    $lec_audiofile = "";
    if(!empty($lecture->uploaded_audio)){
        $lec_audiofile = "<a href='".site_url(UPLOAD_LECTURES_AUDIO.'/'. $lecture->uploaded_audio)."'>". $lecture->uploaded_audio ."</a>";
    }
    ?>
<div class="resent-job-inner">
    <h2><?php echo $lecture->topic;?></h2>
    <ul>
        <li class="first"><span>Posted: <?php echo $lecture->lecture_date;?></span> </li>
        <li> PPT: <?= $lec_file;?> </li>
        <li> Audio: <?= $lec_audiofile;?> </li>
        <li> Tag: <?=$lecture->tags; ?></li>
    </ul>
    <?php echo $lecture->topic_desc;?>
    <p>Referal Link:<?php echo $lecture->refer_links;?></p>
    <?php

    if($lecture->publish_assestment){

        echo "<p>Assessment: ". anchor('student/assestment/view/'. $lecture->id , 'start here') ;
    }


    ?>
</div>
<?php
}
}else{
?>
    <div class="resent-job-inner">
        No lecture uploaded.
    </div>

<?php    }
?>