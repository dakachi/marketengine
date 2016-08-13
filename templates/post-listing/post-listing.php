<?php
/**
 * This template can be overridden by copying it to yourtheme/marketengine/post-listing/post-listing.php.
 * @package     MarketEngine/Templates
 * @version     1.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
?>

<?php if(current_user_can( 'publish_posts' )) : ?>

<?php do_action('marketengine_before_post_listing_form'); ?>

<div id="marketengine-wrapper" class="marketengine">
	<div class="marketengine-post-listing-wrap">
		<form  id="post-listing-form" class="post-listing-form" method="post" accept-charset="utf-8" enctype="multipart/form-data">

			<?php me_print_notices(); ?>

			<?php do_action('marketengine_post_listing_form_start'); ?>

			<?php me_get_template_part('post-listing/listing-category'); ?>

			<?php me_get_template_part('post-listing/listing-type'); ?>
			
			<?php me_get_template_part('post-listing/listing-information'); ?>

			<?php do_action('marketengine_post_listing_information_form_fields'); ?>
		
			<?php me_get_template_part('post-listing/listing-gallery'); ?>
		
			<?php me_get_template_part('post-listing/listing-tags'); ?>

			<?php do_action('marketengine_post_listing_form_fields'); ?>
			
			<?php wp_nonce_field('me-insert_listing'); ?>

			<div class="marketengine-group-field me-text-center submit-post">
				<input class="marketengine-post-submit-btn" type="submit" name="insert_lisiting" value="<?php _e("SUBMIT", "enginethemes"); ?>">
			</div>
			<a href="#" class="back-link-page me-forward-section" data-active="2"><?php _e("&lt; Back to home", "enginethemes"); ?></a>

			<?php do_action('marketengine_post_listing_form_end'); ?>

		</form>
	</div>
</div>

<?php do_action('marketengine_after_post_listing_form'); ?>

<?php else: ?>
	<?php _e("You don't have permission to post listing.", "enginethemes"); ?>
<?php endif; ?>