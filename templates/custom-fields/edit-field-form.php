<?php
/**
 * Render edit listing custom field 
 * This template can be overridden by copying it to yourtheme/marketengine/custom-fields/edit-field-form.php.
 * 
 * @package     MarketEngine/Templates
 * @version     1.0.1
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

if($fields) :
?>
<div class="marketengine-custom-field">
	<?php foreach ($fields as $field) : ?>

		<?php 
			$value = me_field($field['field_name']);
			me_get_template('custom-fields/field-'. $field['field_type'], array('field' => $field, 'listing' => $listing, 'value' => $value)); 
		?>

	<?php endforeach; ?>

</div>
<?php endif; ?>
	
	
<!-- 
	<div class="marketengine-group-field">
		<div class="marketengine-checkbox-field">
		    <label class="me-field-title">Custom field Checkbox</label>
		    <div class="me-checkbox">
		    	<label for="me_cf_checkbox_5"><input id="me_cf_checkbox_5" type="checkbox"><span>Option 1</span></label>	
		    </div>
		    <div class="me-checkbox">
		    	<label for="me_cf_checkbox_6"><input id="me_cf_checkbox_6" type="checkbox"><span>Option 101</span></label>	
		    </div>
		    <div class="me-checkbox">
		    	<label for="me_cf_checkbox_7"><input id="me_cf_checkbox_7" type="checkbox"><span>Option 1001 overnight full options</span></label>
		    </div>
		    
		</div>
	</div>
	<div class="marketengine-group-field">
		<div class="marketengine-radio-field">
		    <label class="me-field-title">Custom field Checkbox</label>
		    <div>
		    	<label class="me-radio" for="me_cf_radio_8"><input id="me_cf_radio_8" name="me_cf_radio" type="radio"><span>Option 1</span></label>	
			    <label class="me-radio" for="me_cf_radio_9"><input id="me_cf_radio_9" name="me_cf_radio" type="radio"><span>Option 101</span></label>	
			   	<label class="me-radio" for="me_cf_radio_10"><input id="me_cf_radio_10" name="me_cf_radio" type="radio"><span>Option 1001 overnight full options</span></label>
			</div>
		</div>
	</div>

	<div class="marketengine-group-field">
		<div class="marketengine-input-field">
		    <label for="me_cf_date_4" class="me-field-title">Custom field single select</label>
		    <select name="" id="" class="me-chosen-select me-cf-chosen">
		    	<option value="">Single select 1</option>
		    	<option value="">Single select 2</option>
		    	<option value="">Single select 3</option>
		    	<option value="">Single select 4</option>
		    </select>
		</div>
	</div>


	<div class="marketengine-group-field">
		<div class="marketengine-input-field">
		    <label for="me_cf_date_4" class="me-field-title">Custom field single select</label>
		    <select name="" id="" class="me-chosen-select me-cf-chosen" multiple="">
		    	<option value="">Single select 1</option>
		    	<option value="">Single select 2</option>
		    	<option value="">Single select 3</option>
		    	<option value="">Single select 4</option>
		    </select>
		</div>
	</div>
-->
