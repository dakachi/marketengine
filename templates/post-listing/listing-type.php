<?php 
$listing_types = me_get_listing_types();
?>
<div class="marketengine-post-step">
	<div class="marketengine-group-field" id="listing-type-container">
		<div class="marketengine-select-field">
		    <label class="text"><?php _e("Listing Type", "enginethemes"); ?></label>
		    <select class="listing-type" name="listing_type" id="listing-type-select">
		    	<?php foreach ($listing_types as $key => $name) : ?>
		    		<option value="<?php echo $key ?>"><?php echo $name; ?></option>
		    	<?php endforeach; ?>
		    </select>
		</div>
	</div>
	<div class="marketengine-group-field">
		<div class="me-row me-pricing-container">
			<div class="me-col-md-6">
				<div class="marketengine-input-field">
				    <label class="text"><?php _e("Price", "enginethemes"); ?></label>
				    <input type="text" name="listing_price" placeholder="$" class="required">
				</div>
			</div>
			<div class="me-col-md-6">
				<div class="marketengine-select-field">
				    <label class="text"><?php _e("Pricing unit", "enginethemes"); ?></label>
				    <select class="pricing-unit" name="pricing_unit">
				    	<option value="none"><?php _e("None", "enginethemes"); ?></option>
				    	<option value="per_unit"><?php _e("Per Unit", "enginethemes"); ?></option>
				    	<option value="per_hour"><?php _e("Per Hour", "enginethemes"); ?></option>
				    </select>
				</div>
			</div>
		</div>
	</div>
</div>