<?php
/**
 *  The template is used to display the Checkout page when user views items in the cart
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$cart_items = me_get_cart_items();


?>
<div class="marketengine">
	<?php
	if(empty($cart_items)) {
		print_r(__("There is no item selected.", "enginethemes"));
		return;
	}
	$listing = me_get_listing(array_keys($cart_items)[0]);
	?>
	<form method="post">
		<div class="me-row">
			<div class="me-col-md-9">
				<?php
				me_get_template('checkout/billing');
				// note
				me_get_template('checkout/note');
				?>
			</div>
			<div class="me-col-md-3">
				<div class="me-checkout-sidebar">
					<?php
					// seller information
					me_get_template('user-info', array('author_id' => $listing->post_author));
					?>
				</div>
			</div>
		</div>

		<?php
		// listing details
		me_get_template('checkout/order-details', array('cart_items' => $cart_items));
		// payment gateways
		// me_get_template('checkout/payment-gateways');
		?>
	</form>
</div>
