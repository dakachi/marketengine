<div class="marketengine-group-field">
	<div class="marketengine-date-field">
	    <?php me_get_template('custom-fields/listing-form/field-label', array('field' => $field));  ?>
	    <input <?php //echo me_field_attribute($field); ?> id="<?php echo $field['field_name'] ?>" type="text" placeholder="<?php echo $field['field_placeholder'] ?>" name="<?php echo $field['field_name'] ?>" value="<?php echo $value; ?>">
	    <i class="icon-me-calendar"></i>
	</div>
</div>