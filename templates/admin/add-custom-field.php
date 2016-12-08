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
					<optgroup label="Basic">
						<option value="text">Text</option>
						<option value="textarea">Textarea</option>
						<option value="number">Number</option>
						<option value="date">Date</option>
					</optgroup>
					<optgroup label="Choose">
						<option value="checkbox">Checkbox</option>
						<option value="radio">Radio</option>
						<option value="single-select">Dropdown Single Select</option>
						<option value="multi-select">Dropdown Multi Select</option>
					</optgroup>
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
					<option value="">Category 1</option>
					<option value="">Category 1100</option>
					<option value="">Category 1001</option>
					<option value="">Category 1011</option>
					<option value="">Category 1101</option>
					<option value="">Category 1001</option>
					<option value="">Category 101</option>
				</select>
			</span>
		</div>

		<div class="me-group-field">
			<label for="" class="me-title"><?php _e('Help text', 'enginethemes'); ?> <small>(<?php _e('optional', 'enginethemes'); ?>)</small></label>
			<span class="me-subtitle">Help text for fields of post listing form</span>
			<textarea class="me-textarea-field"></textarea>
		</div>

		<div class="me-group-field">
			<label for="" class="me-title"><?php _e('Description', 'enginethemes'); ?> <small>(<?php _e('optional', 'enginethemes'); ?>)</small></label>
			<textarea class="me-textarea-field"></textarea>
		</div>
		<input type="submit" class="me-cf-save-btn" value="Save"><a href="" class="me-cf-cancel-btn"><?php _e('Cancel', 'enginethemes'); ?></a>

	</form>
</div>