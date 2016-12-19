<div class="marketengine-group-field">
	<div class="marketengine-textarea-field">
	    <?php me_get_template('custom-fields/listing-form/field-label', array('field' => $field));  ?>
	    <textarea <?php echo me_field_attribute($field); ?> id="<?php echo $field['field_name'] ?>" placeholder="<?php echo $field['field_placeholder'] ?>" name="<?php echo $field['field_name'] ?>"><?php echo $value; ?></textarea>
	</div>
</div>