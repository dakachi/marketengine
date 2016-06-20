<?php do_action('marketengine_before_post_listing_picture_form');?>
<div class="marketengine-group-field">

	<?php do_action('marketengine_before_post_listing_image_form');?>

	<div class="marketengine-upload-field">
		<label class="text"><?php _e("Your listing image", "enginethemes");?>&nbsp;<small><?php _e("(optional)", "enginethemes");?></small></label>
		<input type="file" name='listing_image' accept="image/*" />
	</div>

	<?php do_action('marketengine_after_post_listing_image_form');?>

</div>
<div class="marketengine-group-field">

	<?php do_action('marketengine_before_post_listing_gallery_form');?>

	<div class="marketengine-upload-field">
		<label class="text"><?php _e("Gallery", "enginethemes");?>&nbsp;<small><?php _e("(optional)", "enginethemes");?></small></label>
		<input type="file" name='listing_gallery[]' multiple accept="image/*" />
	</div>

	<?php do_action('marketengine_after_post_listing_gallery_form');?>

</div>
<?php do_action('marketengine_after_post_listing_picture_form');?>