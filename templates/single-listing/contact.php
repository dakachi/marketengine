<?php do_action('marketengine_before_single_listing_contact_button'); ?>

<form method="post">
	<?php do_action('marketengine_single_listing_send_inquiry_form_start'); ?>
	<div class="me-contact">
		<input <?php disabled( !me_is_activated_user() ); ?> type="submit" class="me-buy-now-btn" value="<?php _e("CONTACT NOW", "enginethemes"); ?>">
	</div>
	<?php wp_nonce_field('me-send-inquiry'); ?>
	<input type="hidden" name="send_inquiry" value="<?php the_ID(); ?>" />

	<?php do_action('marketengine_single_listing_send_inquiry_form_end'); ?>
</form>

<?php do_action('marketengine_after_single_listing_contact_button'); ?>
