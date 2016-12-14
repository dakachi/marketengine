<div class="marketengine-group-field">
	<div class="marketengine-date-field">
	    <label for="me_cf_date_4" class="me-field-title">
	    	<?php echo $field['field_title'] ?>
	    	
	    	<?php if(strpos($field['field_constraint'], 'required') === false) : ?>
	    		<small><?php _e("(optional)", "enginethemes"); ?></small>
	    	<?php endif; ?>

	    	<?php if($field['field_help_text']) : ?>
	    		<i class="me-help-text icon-me-question-circle" title="<?php echo $field['field_help_text']; ?>"></i>
	    	<?php endif; ?>
	    </label>
	    <input <?php //echo me_field_attribute($field); ?> id="<?php echo $field['field_name'] ?>" type="text" placeholder="<?php echo $field['field_placeholder'] ?>" name="<?php echo $field['field_name'] ?>" value="<?php echo $value; ?>">
	    <i class="icon-me-calendar"></i>
	</div>
</div>