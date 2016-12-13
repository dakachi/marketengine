<?php
if(isset($field_obj)) {
	$_POST = $field_obj;
}

$constraint = me_field_attribute_array($_POST);

?>

<div class="me-custom-field">
	<?php me_print_notices(); ?>
	<h2><?php _e('Add New Custom Field', 'enginethemes'); ?></h2>
	<form method="post">

		<div class="me-group-field">
			<label for="me-cf-field-name" class="me-title"><?php _e('Field Name', 'enginethemes'); ?></label>
			<span class="me-field-control">
				<input id="me-cf-field-name" name="field_name" class="me-input-field " type="text" value="<?php echo isset($_POST['field_name']) ? esc_attr($_POST['field_name']) : ''; ?>">
			</span>
		</div>

		<div class="me-group-field">
			<label for="" class="me-title"><?php _e('Field Title', 'enginethemes'); ?></label>
			<span class="me-field-control">
				<input id="me-cf-field-title" name="field_title" class="me-input-field " type="text" value="<?php echo isset($_POST['field_title']) ? esc_attr($_POST['field_title']) : ''; ?>">
			</span>
		</div>

		<div class="me-group-field">
			<label for="" class="me-title"><?php _e('Field Type', 'enginethemes'); ?></label>
			<span class="me-select-control">

				<select id="me-choose-field-type" class="select-field" name="field_type" id="">
					<option value=""><?php _e('Choose field type', 'enginethemes'); ?></option>
					<?php
						$field_types = me_list_custom_field_type();
						$field_type = isset($_POST['field_type']) ? $_POST['field_type'] : '';
						if(!empty($field_types)) : ?>
					?>
					<?php foreach ($field_types as $key => $group_value) : ?>
			            <optgroup label="<?php echo $group_value['label']; ?>">
			            <?php foreach ($group_value['options'] as $key => $value) : ?>
			                <option <?php selected($field_type, $key); ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
			            <?php endforeach; ?>
			            </optgroup>
			        <?php endforeach; ?>
			    	<?php endif; ?>
				</select>

			</span>

			<div class="me-field-type-options">
			<?php
				if (isset($_POST['field_type'])) {
					do_action('me_load_cf_input');
				}
			?>
			</div>

		</div>

		<div class="me-group-field">
		<?php
			$checked = isset($constraint['required']) ? 'required' : '';
		?>

			<label class="me-title"><?php _e('Required?', 'enginethemes'); ?></label>
			<span class="me-radio-field">
				<label class="me-radio" for="me-field-required-yes"><input id="me-field-required-yes" type="radio" name="field_constraint" value="required" <?php checked($checked, 'required'); ?>><span><?php _e('Yes', 'enginethemes'); ?></span></label>
				<label class="me-radio" for="me-field-required-no"><input id="me-field-required-no" type="radio" name="field_constraint" value="" <?php checked($checked, ''); ?>><span><?php _e('No', 'enginethemes'); ?></span></label>
			</span>
		</div>

		<div class="me-group-field">
			<label for="" class="me-title"><?php _e('Available In Which Categories', 'enginethemes'); ?></label>
			<span class="me-select-control">
				<select class="select-field" name="field_for_categories[]" id="" multiple="true">

				<?php
					$categories = me_get_listing_categories();
					$selected = isset($_POST['field_for_categories']) ? $_POST['field_for_categories'] : array();
					foreach ($categories as $key => $value) :
				?>
					<option <?php selected(in_array($key, $selected)); ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
				<?php endforeach; ?>

				</select>
			</span>
		</div>

		<div class="me-group-field">
			<label for="" class="me-title"><?php _e('Help text', 'enginethemes'); ?> <small>(<?php _e('optional', 'enginethemes'); ?>)</small></label>
			<span class="me-subtitle"><?php _e('Help text for fields of post listing form', 'enginethemes'); ?></span>
			<textarea class="me-textarea-field" name="field_help_text"><?php echo isset($_POST['field_help_text']) ? $_POST['field_help_text'] : ''; ?></textarea>
		</div>

		<div class="me-group-field">
			<label for="" class="me-title"><?php _e('Description', 'enginethemes'); ?> <small>(<?php _e('optional', 'enginethemes'); ?>)</small></label>
			<textarea class="me-textarea-field" name="field_description"><?php echo isset($_POST['field_description']) ? $_POST['field_description'] : ''; ?></textarea>
		</div>

		<?php wp_nonce_field( 'me-insert_custom_field' ); ?>

		<input type="submit" class="me-cf-save-btn" name="insert-custom-field" value="<?php _e('Save', 'enginethemes'); ?>"><a href="<?php echo me_custom_field_page_url(); ?>" class="me-cf-cancel-btn"><?php _e('Cancel', 'enginethemes'); ?></a>

		<input type="hidden" name="redirect" value="<?php echo me_custom_field_page_url(); ?>">

	</form>
</div>