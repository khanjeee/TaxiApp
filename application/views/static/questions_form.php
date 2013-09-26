<?php 
$answer1= (!empty($answers_arr[0]['answer'])) ? $answers_arr[0]['answer'] : NULL;
$answer2= (!empty($answers_arr[1]['answer'])) ? $answers_arr[1]['answer'] : NULL;
$answer3= (!empty($answers_arr[2]['answer'])) ? $answers_arr[2]['answer'] : NULL;
$answer4= (!empty($answers_arr[3]['answer'])) ? $answers_arr[3]['answer'] : NULL;
$answer5= (!empty($answers_arr[4]['answer'])) ? $answers_arr[4]['answer'] : NULL;

$chkbox1=(!empty($answers_arr[0]['is_correct']) && ($answers_arr[0]['is_correct']==1) ) ? 'checked' : NULL;
$chkbox2=(!empty($answers_arr[1]['is_correct']) && ($answers_arr[1]['is_correct']==1) ) ? 'checked' : NULL;
$chkbox3=(!empty($answers_arr[2]['is_correct']) && ($answers_arr[2]['is_correct']==1) ) ? 'checked' : NULL;
$chkbox4=(!empty($answers_arr[3]['is_correct']) && ($answers_arr[3]['is_correct']==1) ) ? 'checked' : NULL;
$chkbox5=(!empty($answers_arr[4]['is_correct']) && ($answers_arr[4]['is_correct']==1) ) ? 'checked' : NULL;

?>
<div class="form-field-box odd" id="lecture_id_field_box">
	<div class="form-display-as-box" id="lecture_id_display_as_box">Option:1</div>
	<div class="form-input-box" id="lecture_id_input_box">
	<input type="text" maxlength="250" value="<?php echo $answer1; ?>" name="option_1" style="width:250px">
	<input id="field-tester-true" class="radio-uniform" type="checkbox" name="checked_1" value="1" <?php echo $chkbox1; ?>>
					
	</div>
	<div class="clear"></div>
	</div>

	<div class="form-field-box even" id="lecture_id_field_box">
	<div class="form-display-as-box" id="lecture_id_display_as_box">Option:2</div>
	<div class="form-input-box" id="lecture_id_input_box">
	<input type="text" maxlength="250" value="<?php echo $answer2; ?>" name="option_2" style="width:250px">
		<input id="field-tester-true" class="radio-uniform" type="checkbox" name="checked_2" value="1" <?php echo $chkbox2; ?>>
	</div>
	<div class="clear"></div>
	</div>
	
	
	<div class="form-field-box odd" id="lecture_id_field_box">
	<div class="form-display-as-box" id="lecture_id_display_as_box">Option:3</div>
	<div class="form-input-box" id="lecture_id_input_box">
	<input type="text" maxlength="250" value="<?php echo $answer3; ?>" name="option_3" style="width:250px">
		<input id="field-tester-true" class="radio-uniform" type="checkbox" name="checked_3" value="1" <?php echo $chkbox3; ?>>
	
	</div>
	<div class="clear"></div>
	</div>
	
	
	<div class="form-field-box even" id="lecture_id_field_box">
	<div class="form-display-as-box" id="lecture_id_display_as_box">Option:4</div>
	<div class="form-input-box" id="lecture_id_input_box">
	<input type="text" maxlength="250" value="<?php echo $answer4; ?>" name="option_4" style="width:250px">
		<input id="field-tester-true" class="radio-uniform" type="checkbox" name="checked_4" value="1" <?php echo $chkbox4; ?>>
	
	</div>
	<div class="clear"></div>
	</div>
	
	
	<div class="form-field-box odd" id="lecture_id_field_box">
	<div class="form-display-as-box" id="lecture_id_display_as_box">Option:5</div>
	<div class="form-input-box" id="lecture_id_input_box">
	<input type="text" maxlength="250" value="<?php echo $answer5; ?>" name="option_5" style="width:250px">
	<input id="field-tester-true" class="radio-uniform" type="checkbox" name="checked_5" value="1" <?php echo $chkbox5; ?>>
	</div>
	<div class="clear"></div>
	</div>