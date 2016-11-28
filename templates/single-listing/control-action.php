<?php
/**
 * The template for displaying actions seller can do to manage listing.
 *
 * This template can be override by copying it to yourtheme/marketengine/single-listing/control-action.php
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @since       1.0.0
 * @version     1.0.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="me-action">
	<?php if( 'purchasion' === $listing_type ) : ?>
	<?php
		$price = $listing->get_price();
		$pricing_unit = $listing->get_pricing_unit();
	?>

		<span class="me-price">
			<?php echo me_price_html( $price, '', $pricing_unit ); ?>
		</span>
		<?php /* <span class="me-instock"><?php _e("In Stock", "enginethemes"); ?></span> */ ?>
	<?php endif; ?>
		<form method="post">
			<?php me_get_template('account/my-listing-action', array('listing_status' => $listing_status, 'listing_id' => get_the_ID())); ?>
			<?php wp_nonce_field( 'me_update_listing_status' ); ?>
			<input type="hidden" id="listing_id" value="<?php the_ID(); ?>" />
			<input type="hidden" id="redirect_url" value="<?php the_permalink(); ?>" />
		</form>
</div>