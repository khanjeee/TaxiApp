<?php 

$chkbox=(!empty($answers_arr[0]['is_correct']) ) ? $answers_arr[0]['is_correct'] : 'empty';

?>

<div class="pretty-radio-buttons">
	<label> <span class="checked"> <input id="field-tester-true"
			class="radio-uniform" type="radio" name="answer" value="1" <?php echo ($chkbox==1)?'checked' :''; ?>  <?php echo ($chkbox=='empty')?'checked' :''; ?>>
	</span> True
	</label> <label> <span class=""><input id="field-tester-false"
			class="radio-uniform" type="radio" name="answer" value="0" <?php echo ($chkbox==0)?'checked' :''; ?>> </span>
		False
	</label>
</div>

<div class="clear"></div>

