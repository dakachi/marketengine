<?php 
if (!empty($_POST['listing_title'])) {$listing_title =  esc_attr($_POST['listing_title']);}
?>
<?php do_action('marketengine_before_post_listing_information_form'); ?>
<div class="marketengine-group-field">
	<div class="marketengine-input-field">
	    <label class="text"><?php _e("Listing title", "enginethemes");?></label>
	    <input type="text" name="listing_title" value="<?php echo esc_html( $listing_title ) ?>" class="required">
	</div>
</div>
<div class="marketengine-group-field">
	<div class="marketengine-textarea-field">
		<label class="text"><?php _e("Listing description", "enginethemes");?></label>
		<?php 
			$listing_content = !empty($_POST['listing_description']) ? $_POST['listing_description'] : $listing_content;
			wp_editor(
			    esc_js( $listing_content ),
			    'listing_description',
			    array(
			        'quicktags' => false,
			        'media_buttons' => false,
			        'wpautop' => true,
			        'teeny' => true,
			    )
			);
		?>
	</div>
</div>
<?php do_action('marketengine_after_post_listing_information_form'); ?>