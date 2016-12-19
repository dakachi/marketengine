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
			$value = me_field($field['field_name'], $listing, array('fields' => 'ids'));
			me_get_template('custom-fields/field-'. $field['field_type'], array('field' => $field, 'value' => $value)); 
		?>

	<?php endforeach; ?>

</div>
<?php endif; ?>
