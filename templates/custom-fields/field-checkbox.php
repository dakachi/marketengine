<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
$options = me_cf_get_field_options($field['field_name']);
if(empty($options)) return;
?>
<div class="marketengine-group-field">
	<div class="marketengine-checkbox-field">
	    <?php me_get_template('custom-fields/field-label', array('field' => $field));  ?>
	    <?php foreach ($options as $option) : ?>
		    <div class="me-checkbox">
		    	<label for="<?php echo $option['value'] ?>">
		    			<input id="<?php echo $option['value'] ?>" name="me_cf_radio" type="checkbox">
		    			<span><?php echo $option['label']; ?></span>
		    		</label>	
		    </div>
	    <?php endforeach; ?>
	</div>
</div>