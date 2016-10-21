<?php
// get cart item tu session
$total = 0;
?>
<?php do_action( 'marketengine_before_checkout_form' ); ?>
<div class="me-shopping-cart">
	<h3><?php _e("Your order", "enginethemes"); ?></h3>
	<div class="me-table me-cart-table">
		<div class="me-table-rhead">
			<div class="me-table-col me-cart-name"><?php _e("Listing", "enginethemes"); ?></div>
			<div class="me-table-col me-cart-price"><?php _e("Price", "enginethemes"); ?></div>
			<div class="me-table-col me-cart-units"><?php _e("Units", "enginethemes"); ?></div>
			<div class="me-table-col me-cart-units-total"><?php _e("Total price", "enginethemes"); ?></div>
		</div>

		<?php do_action( 'marketengine_before_cart_item_list' ); ?>

		<?php foreach ($cart_items as $key => $item) :
			$listing =  me_get_listing(absint( $item['id'] ));

			$total += $listing->get_price();
			$unit = ($item['qty']) ? $item['qty'] : 1;
		?>

		<div class="me-table-row me-cart-item">
			<div class="me-table-col me-cart-name">
				<div class="me-cart-listing">
					<a href="<?php echo get_permalink( $listing->ID ); ?>">
						<?php echo get_the_post_thumbnail($listing->ID); ?>
						<span><?php echo esc_html(get_the_title($listing->ID)); ?></span>
					</a>
				</div>
			</div>
			<div class="me-table-col me-cart-price">
				$<?php echo $listing->get_price(); ?>
			</div>
			<div class="me-table-col me-cart-units">
				<?php echo $unit ?>
			</div>
			<div class="me-table-col me-cart-units-total">
				$<?php echo ($listing->get_price()) * $unit; ?>
			</div>

			<input type="hidden" name="listing_item[<?php echo $key; ?>][id]" value="<?php echo $item['id']; ?>" />
			<input type="hidden" name="listing_item[<?php echo $key; ?>][qty]" value="<?php echo $unit; ?>" />
		</div>

		<?php endforeach; ?>

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
			<div class="me-table-col me-cart-totals">$<?php echo ($listing->get_price()) * $unit;  ?></div>
		</div>
	</div>
	<?php wp_nonce_field('me-checkout'); ?>
	<div>
		<input type="hidden" name="payment_method" value="ppadaptive" />
	</div>
	<div class="me-checkout-submit">
		<input class="me-checkout-submit-btn" type="submit" name="checkout" value="<?php _e("MAKE PAYMENT", "enginethemes"); ?>">
	</div>
</div>

<?php do_action( 'marketengine_after_checkout_form' ); ?>

<?php wp_reset_postdata(); ?>