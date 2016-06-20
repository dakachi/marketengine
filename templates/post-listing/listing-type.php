<?php 
$listing_types = me_get_listing_types();
?>

<?php do_action('marketengine_before_post_listing_type_form'); ?>

<div class="marketengine-group-field" id="listing-type-container">

	<?php do_action('marketengine_post_listing_type_form_start'); ?>

	<div class="marketengine-select-field">
	    <label class="text"><?php _e("Listing Type", "enginethemes"); ?></label>
	    <select class="listing-type" name="listing_type" id="listing-type-select">
	    	<?php foreach ($listing_types as $key => $name) : ?>
	    		<option value="<?php echo $key ?>"><?php echo $name; ?></option>
	    	<?php endforeach; ?>
	    </select>
	</div>

	<?php do_action('marketengine_post_listing_type_form_end'); ?>

</div>
<div class="marketengine-group-field">

	<?php do_action('marketengine_post_listing_type_form_fields_start'); ?>

	<div class="me-row me-pricing-container listing-type-info" id="purchasion-type-field">

		<?php do_action('marketengine_post_listing_price_form_start'); ?>

		<div class="me-col-md-6">
			<div class="marketengine-input-field">
			    <label class="text"><?php _e("Price", "enginethemes"); ?></label>
			    <input type="number" name="meta_input[listing_price]" placeholder="$" class="required" value="<?php if (!empty($_POST['meta_input']['listing_price'])) {echo esc_attr($_POST['meta_input']['listing_price']);}?>">
			</div>
		</div>
		<div class="me-col-md-6">
			<div class="marketengine-select-field">
			    <label class="text"><?php _e("Pricing unit", "enginethemes"); ?></label>
			    <select class="pricing-unit" name="meta_input[pricing_unit]">
			    	<option value="none"><?php _e("None", "enginethemes"); ?></option>
			    	<option value="per_unit"><?php _e("Per Unit", "enginethemes"); ?></option>
			    	<option value="per_hour"><?php _e("Per Hour", "enginethemes"); ?></option>
			    </select>
			</div>
		</div>

		<?php do_action('marketengine_post_listing_price_form_end'); ?>

	</div>
	
	<?php do_action('marketengine_post_listing_type_form_fields'); ?>

	<div class="marketengine-input-field listing-type-info" id="contact-type-field" style="display:none;">

		<?php do_action('marketengine_post_listing_offering_email_form_start'); ?>

	    <label class="text"><?php _e("Contact Email", "enginethemes");?></label>
	    <input type="email" name="meta_input[offering_email]" value="<?php if (!empty($_POST['meta_input']['offering_email'])) {echo esc_attr($_POST['meta_input']['offering_email']);}?>" >
	    
	    <?php do_action('marketengine_post_listing_offering_email_form_end'); ?>

	</div>

	<?php do_action('marketengine_post_listing_type_form_fields_end'); ?>

</div>
<?php do_action('marketengine_after_post_listing_type_form'); ?>