<?php if($field) :?>
<div class="marketengine-group-field">
	<div class="marketengine-input-field">
	    <label for="<?php echo $field['field_name'] ?>" class="me-field-title">
	    	<?php echo $field['field_title'] ?>
	    </label>
	    <input id="<?php echo $field['field_name'] ?>" type="text" placeholder="<?php echo $field['field_placeholder'] ?>" name="<?php echo $field['field_name'] ?>" value="<?php echo $value; ?>" >
	</div>
</div>
<?php endif; ?>