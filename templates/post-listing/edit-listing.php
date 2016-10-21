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

<?php if($listing) : ?>

<?php do_action('marketengine_before_edit_listing_form', $listing); ?>

<div id="marketengine-wrapper" class="marketengine">
	<div class="marketengine-post-listing-wrap">
		<form  id="post-listing-form" class="post-listing-form" method="post" accept-charset="utf-8" enctype="multipart/form-data">

			<?php me_print_notices(); ?>

			<?php do_action('marketengine_edit_listing_form_start', $listing); ?>

			<?php me_get_template('post-listing/listing-category', array('listing', $listing)); ?>

			<?php me_get_template('post-listing/listing-type', array('listing', $listing)); ?>

			<?php me_get_template('post-listing/listing-information', array('listing', $listing)); ?>

			<?php do_action('marketengine_edit_listing_information_form_fields', $listing); ?>

			<?php me_get_template('post-listing/listing-gallery', array('listing' => $listing)); ?>

			<?php me_get_template('post-listing/listing-tags', array('listing', $listing)); ?>

			<?php do_action('marketengine_edit_listing_form_fields', $listing); ?>

			<?php wp_nonce_field('me-edit_listing'); ?>

			<div class="marketengine-group-field me-text-center submit-post">
				<input class="marketengine-post-submit-btn" type="submit" name="insert_lisiting" value="<?php _e("SUBMIT", "enginethemes"); ?>">
			</div>
			<a href="#" class="back-link-page me-forward-section" data-active="2"><?php _e("&lt; Back to home", "enginethemes"); ?></a>

			<?php do_action('marketengine_edit_listing_form_end', $listing); ?>

		</form>
	</div>
</div>

<?php do_action('marketengine_after_edit_listing_form', $listing); ?>
<?php endif; ?>