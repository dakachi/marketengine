<div class="me-item-contact">
	<span class="post-price"><?php _e("Contact", "enginethemes"); ?></span>
</div>
<div class="me-contact-now">
	<form method="post">
		<?php do_action('marketengine_single_listing_send_inquiry_form_start'); ?>
		<div class="me-contact">
			<input type="submit" class="me-buy-now-btn" value="<?php _e("CONTACT NOW", "enginethemes"); ?>">
		</div>

		<?php wp_nonce_field('me-send-inquiry'); ?>

		<input type="hidden" name="send_inquiry" value="<?php the_ID(); ?>" />
		<?php do_action('marketengine_single_listing_send_inquiry_form_end'); ?>
	</form>
</div>