<div class="me-custom-field">
	<h2><?php _e('Add New Custom Field', 'enginethemes'); ?></h2>
	<form action="">

		<div class="me-group-field">
			<label for="me-cf-field-name" class="me-title"><?php _e('Field Name', 'enginethemes'); ?></label>
			<span class="me-field-control">
				<input id="me-cf-field-name" class="me-input-field " type="text">
			</span>
		</div>

		<div class="me-group-field">
			<label for="" class="me-title"><?php _e('Field Title', 'enginethemes'); ?></label>
			<span class="me-field-control">
				<input id="me-cf-field-title" class="me-input-field " type="text">
			</span>
		</div>

		<div class="me-group-field">
			<label for="" class="me-title"><?php _e('Field Type', 'enginethemes'); ?></label>
			<span class="me-select-control">
				<select id="me-choose-field-type" class="select-field" name="" id="">
					<option><?php _e('Choose field type', 'enginethemes'); ?></option>
					<?php $field_types = me_list_custom_field_type(); ?>
					<?php foreach ($field_types as $key => $group_value) : ?>
			            <optgroup label="<?php echo $group_value['label']; ?>">
			            <?php foreach ($group_value['options'] as $key => $value) : ?>
			                <option <?php selected($option_value, $key); ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
			            <?php endforeach; ?>
			            </optgroup>
			        <?php endforeach; ?>
				</select>
			</span>
			<div class="me-field-type-options">

				<!-- Options field type - TEXT
				<div class="me-group-field">
					<label class="me-title">Placeholder <small>(optional)</small></label>
					<span class="me-field-control">
						<input class="me-input-field" type="text">
					</span>
				</div>
				-->

				<!-- Options field type - TEXTAREA
				<div class="me-group-field">
					<label class="me-title">Placeholder <small>(optional)</small></label>
					<span class="me-field-control">
						<input class="me-input-field" type="text">
					</span>
				</div>
				-->

				<!-- Options field type - NUMBER
				<div class="me-group-field">
					<label class="me-title">Placeholder <small>(optional)</small></label>
					<span class="me-field-control">
						<input class="me-input-field" type="text">
					</span>
				</div>
				<div class="me-group-field">
					<label class="me-title">Minimum value <small>(optional)</small></label>
					<span class="me-field-control">
						<input class="me-input-field" type="number">
					</span>
				</div>
				<div class="me-group-field">
					<label class="me-title">Maximum value <small>(optional)</small></label>
					<span class="me-field-control">
						<input class="me-input-field" type="number">
					</span>
				</div>
				-->

				<!-- Options field type - CHECKBOX
				<div class="me-group-field">
					<label class="me-title">Options</label>
					<span class="me-field-control">
						<textarea class="me-textarea-field" placeholder="Enter each option on a new line"></textarea>
					</span>
				</div>
				-->

				<!-- Options field type - RADIO
				<div class="me-group-field">
					<label class="me-title">Options</label>
					<span class="me-field-control">
						<textarea class="me-textarea-field" placeholder="Enter each option on a new line"></textarea>
					</span>
				</div>
				-->

				<!-- Options field type - SINGLE SELECT | MULTI SELECT
				<div class="me-group-field">
					<label class="me-title">Option none</label>
					<span class="me-field-control">
						<input class="me-input-field" type="text">
					</span>
				</div>

				<div class="me-group-field">
					<label class="me-title">Options</label>
					<span class="me-field-control">
						<textarea class="me-textarea-field" placeholder="Enter each option on a new line"></textarea>
					</span>
				</div>
				-->

			</div>
		</div>

		<div class="me-group-field">
			<label class="me-title"><?php _e('Required?', 'enginethemes'); ?></label>
			<span class="me-radio-field">
				<label class="me-radio" for="me-field-required-yes"><input id="me-field-required-yes" type="radio" name="field_required" checked><span><?php _e('Yes', 'enginethemes'); ?></span></label>
				<label class="me-radio" for="me-field-required-no"><input id="me-field-required-no" type="radio" name="field_required"><span><?php _e('No', 'enginethemes'); ?></span></label>
			</span>
		</div>

		<div class="me-group-field">
			<label for="" class="me-title"><?php _e('Available In Which Categories', 'enginethemes'); ?></label>
			<span class="me-select-control">
				<select class="select-field" name="" id="" multiple="true">

				<?php
					$categories = me_get_listing_categories();
					foreach ($categories as $key => $value) :
				?>
					<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
				<?php endforeach; ?>

				</select>
			</span>
		</div>

		<div class="me-group-field">
			<label for="" class="me-title"><?php _e('Help text', 'enginethemes'); ?> <small>(<?php _e('optional', 'enginethemes'); ?>)</small></label>
			<span class="me-subtitle"><?php _e('Help text for fields of post listing form', 'enginethemes'); ?></span>
			<textarea class="me-textarea-field"></textarea>
		</div>

		<div class="me-group-field">
			<label for="" class="me-title"><?php _e('Description', 'enginethemes'); ?> <small>(<?php _e('optional', 'enginethemes'); ?>)</small></label>
			<textarea class="me-textarea-field"></textarea>
		</div>

		<?php wp_nonce_field( 'add_custom_field' ); ?>

		<input type="submit" class="me-cf-save-btn" value="<?php _e('Save', 'enginethemes'); ?>"><a href="<?php echo add_query_arg('section', 'custom-field', me_menu_page_url('me-settings', 'marketplace-settings')); ?>" class="me-cf-cancel-btn"><?php _e('Cancel', 'enginethemes'); ?></a>

	</form>
</div>