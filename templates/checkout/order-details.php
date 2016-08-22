<?php
// get cart item tu session
$post = get_post(3830);
setup_postdata( $post );
$listing =  me_get_listing();
$unit = 1;


$total = $listing->get_price() + $listing->get_shipping_fee();

?>

<?php do_action( 'marketengine_before_checkout_form', $post ); ?>

<div class="me-shopping-cart">
	<h3><?php _e("Your order", "enginethemes"); ?></h3>
	<div class="me-table me-cart-table">

		<?php do_action( 'marketengine_before_cart_item_list' ); ?>

		<div class="me-table-row me-cart-item">
			<div class="me-table-col me-cart-name">
				<span><?php _e("Item", "enginethemes"); ?></span>
				<span>
					<div class="me-cart-listing">
						<a href="">
							<?php the_post_thumbnail(); ?>
							<span><?php the_title(); ?></span>
						</a>
					</div>
				</span>
			</div>
			<div class="me-table-col me-cart-price">
				<span><?php _e("Price", "enginethemes"); ?></span>
				<span>$<?php echo $listing->get_price(); ?></span>
			</div>
			<div class="me-table-col me-cart-units-total">
				<div class="me-cart-units">
					<span><?php _e("Units", "enginethemes"); ?></span>
					<span><?php echo $unit ?></span>
				</div>
				<div class="me-cart-total">
					<span><?php _e("Total price", "enginethemes"); ?></span>
					<span>$<?php echo ($listing->get_price()) * $unit; ?></span>
				</div>
			</div>
		</div>

		<?php do_action( 'marketengine_after_cart_item_list' ); ?>

		<?php if($listing->get_shipping_fee()): ?>
			<div class="me-table-row">
				<div class="me-table-col me-table-empty"></div>
				<div class="me-table-col me-table-empty"></div>
				<div class="me-table-col me-cart-shippingfee">
					<span><?php _e("Shipping fee:", "enginethemes"); ?></span>
					<span>$<?php echo $listing->get_shipping_fee(); ?></span>
				</div>
			</div>
		<?php endif; ?>

		<div class="me-table-row">
			<div class="me-table-col me-table-empty"></div>
			<div class="me-table-col me-table-empty"></div>
			<div class="me-table-col me-cart-totals">
				<span><?php _e("Total amount:", "enginethemes"); ?></span>
				<span>$<?php echo $total  ?></span>
			</div>
		</div>
	</div>

	<div class="me-checkout-submit">
		<input class="me-checkout-submit-btn" type="submit" value="<?php _e("MAKE PAYMENT", "enginethemes"); ?>">
	</div>
</div>

<?php do_action( 'marketengine_after_checkout_form', $post ); ?>

<?php wp_reset_postdata(); ?>