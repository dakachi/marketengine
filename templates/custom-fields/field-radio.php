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
	    		<label class="me-radio" for="<?php echo $option['value'] ?>">
	    			<input id="<?php echo $option['value'] ?>" name="me_cf_radio" type="radio">
	    			<span><?php echo $option['label']; ?></span>
	    		</label>	
	    	<?php endforeach; ?>
		</div>
	</div>
</div>