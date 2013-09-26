<?php
$html =  "<br/><br/>
            <table class='border_table' cellspacing='10' cellpadding='10'>".
            "<tr class='th_id'><td style='width:100px;'>Code</td><td>Course</td><td style='width:100px;'>Detail</td></tr>";

if(count($list) > 0){
    foreach($list as $item){
        $html .= "<tr><td>".$item['code']. "</td><td>".$item['name']."</td><td style='text-decoration: none;
                color: #007fda;'>". anchor('student/courses/view/'. $item['assign_course_id'] , 'click here')."</td></tr>";
    }
}else {
    $html .= "<tr><td colspan='3'>No record found.</td></tr>";
}

    $html .= "</table>";

echo $html;
?>
<?php
//        $html =  "";
//        foreach($list as $item){
//            $html .= '<div class="resent-job-inner">
//                      <h2>'.$item['name'].'</h2>
//                      <ul>
//                        <li class="first"><span>Code : '.$item['code'].'</span> </li>
//                        <li> Department : '.$item['department'].'</li>
//                        <li> Year : '.$item['year'].'</li>
//                        <li>Section : '.$item['section'].'</li>
//                        <p>Description : '.$item['description'].'Detail : '.anchor('student/courses/view/'. $item['assign_course_id'] , ucfirst('click here')).'</p>
//
//                      </ul>
//                    </div>';
//
//
//        }
//
//        echo $html;
    ?>

