<?php
#echo $this->Form->input('roteiros', array('class'=>'selectpicker span12', 'type' => 'select', 'options' => $roteiros, ));
?>

<label for="MonteRoteiroRoteiros">roteiros</label>
<select name="data[MonteRoteiro][roteiros]" id="MonteRoteiroRoteiros" class="selectpicker span12">
	<? foreach ($roteiros as $key => $roteiro): ?>
		<option <? if ($roteiro == $roteiro_select) echo 'selected'; ?> value="<?php echo $roteiro; ?>"><?php echo $roteiro; ?></option>
	<? endforeach; ?>
</select>