<?php
/**
 * The template for displaying information of listing ordered.
 *
 * This template can be overridden by copying it to yourtheme/marketengine/purchases/order-listing.php.
 *
 * @package     MarketEngine/Templates
 * @since 		1.0.0
 * @version     1.0.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="me-orderlisting-info">
<?php if ($listing_obj) : ?>
	<?php me_get_template('purchases/order-listing-image', array('listing_obj' => $listing_obj)); ?>

	<div class="me-listing-info">
		<div class="me-row">
			<div class="me-col-md-8">

				<h2><a href="<?php echo $listing_obj && (($listing_obj->get_author() == get_current_user_id()) || $listing_obj->is_available()) ? $listing_obj->get_permalink() : 'javascript:void(0)'; ?>"><?php echo esc_html($cart_listing['title']); ?></a></h2>
				<div class="me-rating">
					<div class="result-rating" data-score="<?php echo $listing_obj->get_review_score(); ?>"></div>
				</div>
				<div class="me-count-purchases-review">
					<span><?php printf(_n('%d Purchase', '%d Purchases', $listing_obj->get_order_count(), 'enginethemes'), $listing_obj->get_order_count()); ?></span>
					<span><?php printf(_n('%d Review', '%d Reviews', $listing_obj->get_review_count(), 'enginethemes'), $listing_obj->get_review_count()); ?></span>
				</div>
			</div>
			<div class="me-col-md-4">
				<?php
					$seller = $listing_obj->get_author();
					$can_rate = $seller != get_current_user_id() && $listing_obj->is_available();
				?>
				<?php if( $can_rate  && !me_get_user_rate_listing_score($listing_obj->ID, $transaction->post_author) && !$transaction->has_status('me-pending') ) : ?>
					<a class="me-orderlisting-review" href="<?php echo add_query_arg(array('id' => $listing_obj->ID, 'action' => 'review')); ?>">
						<?php _e('RATE &amp; REVIEW NOW', 'enginethemes'); ?>
					</a>
				<?php endif; ?>

				<?php me_get_template('purchases/archived-listing-notice', array('listing_obj' => $listing_obj) ); ?>

			</div>
		</div>

		<?php /*
		<div class="me-listing-desc">
			<div class="me-listing-desc-less">
				<?php echo $listing_obj->get_short_description(20); ?>
			</div>
			<div class="me-listing-desc-more">
				<p><?php echo $listing_obj->get_description(); ?></p>
			</div>
		</div>
		<a class="me-listing-info-view"><span><?php _e('view more', 'enginethemes'); ?></span><span><?php _e('view less', 'enginethemes'); ?></span></a>
		*/ ?>
	
	</div>

<?php endif; ?>

</div>