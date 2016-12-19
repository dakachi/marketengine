<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
$options = me_cf_get_field_options($field['field_name']);
if(empty($options)) return;
?>
<div class="marketengine-group-field">
	<div class="marketengine-radio-field">
	    <?php me_get_template('custom-fields/field-label', array('field' => $field));  ?>
	    <div>
	    	<?php foreach ($options as $option) : ?>
	    		<label class="me-radio" for="<?php echo $field['field_name'] ?>-<?php echo $option['value']; ?>">
	    			<input value="<?php echo $option['value']; ?>" name="<?php echo $field['field_name'] ?>" id="<?php echo $field['field_name'] ?>-<?php echo $option['value']; ?>" type="radio" <?php if(in_array($option['value'], (array)$value)) {echo 'checked="true"';} ?>>
	    			<span><?php echo $option['label']; ?></span>
	    		</label>	
	    	<?php endforeach; ?>
		</div>
	</div>
</div>