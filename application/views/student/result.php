<div>
    <p>You assessment is completed and recorded.<br/>Your score is <?= $score;?> out of <?= $num_of_questions; ?></p>
</div>
<div class="job-detail">
    <h1>Assessment Result</h1>
    <?php
    foreach($questions as $key => $question){
        $output = $assestment[$question->id];
        $colorClass = ($output['result']) ? 'green' : 'red';
        echo "<div class='detail {$colorClass}'><div class='question'><span>". ($key+1) .")</span>". $question->question ."</div><div style='clear:both;'></div>";
        foreach($answers as $answer){
            if($question->type == 'MCQ' ){
                if($answer['question_id'] == $question->id){
                    if($answer['id'] == $output['answer'])
                        echo "<div class='answer-option'><input disabled='disabled' type='radio' checked='checked'  name='question[". $question->id ."][answer]' value='". $answer['id'] ."'><span>". $answer['answer'] ."</span></div>";
                    else
                        echo "<div class='answer-option'><input disabled='disabled' type='radio'  name='question[". $question->id ."][answer]' value='". $answer['id'] ."'><span>". $answer['answer'] ."</span></div>";

                }
            }else{
                if($answer['question_id'] == $question->id){
                    if($answer['answer']=='FALSE'){
                        if($answer['id']== $output['answer']){
                            echo "<div class='answer-option'><input disabled='disabled' type='radio' name='question[". $question->id ."][answer]' value='0'><span>TRUE</span></div>";
                            echo "<div class='answer-option'><input disabled='disabled' checked='checked'  type='radio' name='question[". $question->id ."][answer]' value='". $answer['id'] ."'><span>". $answer['answer'] ."</span></div>";
                        }else{
                            echo "<div class='answer-option'><input disabled='disabled' checked='checked' type='radio' name='question[". $question->id ."][answer]' value='0'><span>TRUE</span></div>";
                            echo "<div class='answer-option'><input disabled='disabled' type='radio' name='question[". $question->id ."][answer]' value='". $answer['id'] ."'><span>". $answer['answer'] ."</span></div>";
                        }
                    }else{
                        if($answer['id']== $output['answer']){
                            echo "<div class='answer-option'><input disabled='disabled' checked='checked' type='radio' name='question[". $question->id ."][answer]' value='". $answer['id'] ."'><span>". $answer['answer'] ."</span></div>";
                            echo "<div class='answer-option'><input disabled='disabled' type='radio' name='question[". $question->id ."][answer]' value='0'><span>FALSE</span></div>";
                        }else{
                            echo "<div class='answer-option'><input disabled='disabled' type='radio' name='question[". $question->id ."][answer]' value='". $answer['id'] ."'><span>". $answer['answer'] ."</span></div>";
                            echo "<div class='answer-option'><input disabled='disabled' checked='checked' type='radio' name='question[". $question->id ."][answer]' value='0'><span>FALSE</span></div>";

                        }
                    }
                }
            }
        }

        echo "<br/><div class='reason'><b>Reason:</b> ". $question->reason. "</div>";
        echo "</div>";
    }
    ?>
</div>
