<form id="student_answers" method="post" >
        <div class="job-detail">
            <h1>Assessment</h1>
        <?php
            foreach($questions as $key => $question){
                echo "<div class='detail'><div class='question'><span>". ($key+1) .")</span>". $question->question ."</div><div style='clear:both;'></div>";

                foreach($answers as $answer){
                    if($question->type == 'MCQ' ){
                    if($answer['question_id'] == $question->id){
                        echo "<div class='answer-option'><input type='radio' name='question[". $question->id ."][answer]' value='". $answer['id'] ."'><span>". $answer['answer'] ."</span></div>";
                    }
                    }else{
                        if($answer['question_id'] == $question->id){
                            if($answer['answer']=='FALSE'){
                                echo "<div class='answer-option'><input type='radio' name='question[". $question->id ."][answer]' value='0'><span>TRUE</span></div>";
                                echo "<div class='answer-option'><input type='radio' name='question[". $question->id ."][answer]' value='". $answer['id'] ."'><span>". $answer['answer'] ."</span></div>";
                            }else{
                                echo "<div class='answer-option'><input type='radio' name='question[". $question->id ."][answer]' value='". $answer['id'] ."'><span>". $answer['answer'] ."</span></div>";
                                echo "<div class='answer-option'><input type='radio' name='question[". $question->id ."][answer]' value='0'><span>FALSE</span></div>";
                            }
                        }
                    }
                }
                echo "</div>";
            }

            if(!empty($questions)){
                echo "<div class='submit-btn'><input type='submit' value='Finish'></div>";
            }
        ?>
    </div>
</form>

