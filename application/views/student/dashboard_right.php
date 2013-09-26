<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irfan
 * Date: 9/11/13
 * Time: 12:21 AM
 * To change this template use File | Settings | File Templates.
 */
?>

    <h1>Assessments</h1>
    <ul>
    <?php
        $item = "";
        foreach($last5assessments as $assessment){
            $item .= '<li><h1>' . $assessment['name'] . "</h1><h4>". $assessment['topic'] . "</h4>". date('dS M Y h:ia',strtotime( $assessment['created_on'])) . " | ". $assessment['score']. "</li>";
        }
        echo $item;
    ?>
    </ul>

