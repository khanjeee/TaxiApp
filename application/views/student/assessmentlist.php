<?php
$html =  "<br/><br/><table class='border_table' cellspacing='10' cellpadding='10'>" .
            "<tr class='th_id'><td>Assessment taken</td><td style='width:150px;'>Score</td></tr>";

if(count($list) > 0){
    foreach($list as $item){
        $html .= "<tr><td>". date('d M Y, H:i', strtotime($item['created_on'])). "</td><td >".$item['score']."</td></tr>";
    }
}else {
    $html .= "<tr><td colspan='2'>No record found.</td></tr>";
}

$html .= "</table>";

echo $html;
?>