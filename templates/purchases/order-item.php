<?php
/**
 * The template for displaying order item.
 *
 * This template can be overridden by copying it to yourtheme/marketengine/account/confirm-email.php.
 *
 * @package     MarketEngine/Templates
 * @since 		1.0.0
 * @version     1.0.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$total = 0;
?>
<?php do_action( 'marketengine_before_checkout_form' ); ?>
<div class="me-shopping-cart">
	<h5><?php _e("Order Item", "enginethemes"); ?></h5>
	<div class="me-table me-cart-table">
		<div class="me-table-rhead">
			<div class="me-table-col me-cart-name"><?php _e("Listing", "enginethemes"); ?></div>
			<div class="me-table-col me-cart-price"><?php _e("Price", "enginethemes"); ?></div>
			<div class="me-table-col me-cart-units"><?php _e("Units", "enginethemes"); ?></div>
			<div class="me-table-col me-cart-units-total"><?php _e("Total price", "enginethemes"); ?></div>
		</div>

		<?php do_action( 'marketengine_before_cart_item_list' ); ?>

		<?php
			$listing = $listing_item['ID'];
			$unit = ($listing_item['qty']) ? $listing_item['qty'][0] : 1;
		?>

		<div class="me-table-row me-cart-item">
			<div class="me-table-col me-cart-name">
				<div class="me-cart-listing">
				<?php marketengine_get_template('purchases/order-listing-image', array('listing_obj' => $listing_obj) ); ?>

					<a href="<?php echo $listing_obj && (($listing_obj->get_author() == get_current_user_id()) || $listing_obj->is_available()) ? get_permalink( $listing_obj->ID ) : 'javascript:void(0)'; ?>">
						<span><?php echo esc_html($listing_item['title']); ?></span>
					</a>

				<?php marketengine_get_template('purchases/archived-listing-notice', array('listing_obj' => $listing_obj) ); ?>
				</div>
			</div>
			<div class="me-table-col me-cart-price">
				<?php echo marketengine_price_html( $listing_item['price'] ); ?>
				<span class="me-cart-price-mobile"><?php _e("Price", "enginethemes"); ?></span>
			</div>
			<div class="me-table-col me-cart-units">
				<?php echo $unit ?>
				<span class="me-cart-units-mobile"><?php _e("Units", "enginethemes"); ?></span>
			</div>
			<div class="me-table-col me-cart-units-total">
				<?php echo marketengine_price_html($listing_item['price'] * $unit); ?>
			</div>

			<input type="hidden" name="listing_item[<?php echo $key; ?>][id]" value="<?php echo $item['id']; ?>" />
			<input type="hidden" name="listing_item[<?php echo $key; ?>][qty]" value="<?php echo $unit; ?>" />
		</div>

		<?php do_action( 'marketengine_after_cart_item_list' ); ?>
		<?php /* if( $listing->get_shipping_fee() ): ?>
			<div class="me-table-row me-cart-rshippingfee">
				<div class="me-table-col me-table-empty"></div>
				<div class="me-table-col me-table-empty"></div>
				<div class="me-table-col me-cart-shippingfee"><?php _e("Shipping fee:", "enginethemes"); ?></div>
				<div class="me-table-col me-cart-shippingfee-price">$<?php echo $listing->get_shipping_fee(); ?></div>
			</div>
		<?php endif; */ ?>

		<div class="me-table-row me-cart-rtotals">
			<div class="me-table-col me-table-empty"></div>
			<div class="me-table-col me-table-empty"></div>
			<div class="me-table-col me-cart-amount"><?php _e("Total amount:", "enginethemes"); ?></div>
			<div class="me-table-col me-cart-totals"><?php echo marketengine_price_html($listing_item['price'] * $unit); ?></div>
		</div>
	</div>
	<div class="me-checkout-submit">
	<?php if( $transaction->post_status === 'me-pending' && $listing_obj && $listing_obj->is_available() ) : ?>
		<form method="post">
			<?php wp_nonce_field('me-pay'); ?>
			<input type="hidden" name="order_id" value="<?php echo $transaction->id; ?>" />
			<input type="hidden" name="payment_method" value="ppadaptive" />
			<input class="me-checkout-submit-btn" type="submit" name="checkout" value="<?php _e("COMPLETE PAYMENT", "enginethemes"); ?>">
		</form>
	<?php endif; ?>
	</div>
</div>

<?php do_action( 'marketengine_after_checkout_form' ); ?>

<?php wp_reset_postdata(); ?>