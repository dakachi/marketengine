<div class="marketengine-group-field">
	<div class="marketengine-input-field">
	    <?php me_get_template('custom-fields/field-label', array('field' => $field));  ?>
	    <input <?php //echo me_field_attribute($field); ?> id="<?php echo $field['field_name'] ?>" type="number" placeholder="<?php echo $field['field_placeholder'] ?>" name="<?php echo $field['field_name'] ?>" value="<?php echo $value; ?>">
	</div>
</div>