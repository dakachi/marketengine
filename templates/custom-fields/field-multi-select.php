<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
$options = me_cf_get_field_options($field['field_name']);
?>
<div class="marketengine-group-field">
	<div class="marketengine-input-field">
	    <?php me_get_template('custom-fields/field-label', array('field' => $field));  ?>
	    <select name="<?php echo $field['field_name'] ?>" id="<?php echo $field['field_name'] ?>" class="me-chosen-select me-cf-chosen" multiple="true">
	    	<?php foreach ($options as $option) : ?>
	    		<option value="<?php echo $option['value'] ?>"><?php echo $option['label']; ?></option>
	    	<?php endforeach; ?>
	    </select>
	</div>
</div>