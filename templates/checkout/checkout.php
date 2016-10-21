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
	<?php me_print_notices(); ?>
	<?php
	if(empty($cart_items)) {
		print_r(__("There is no item selected.", "enginethemes"));
		return;
	}
	?>
	<form method="post">
		<?php
		me_get_template('checkout/billing');
		// note
		me_get_template('checkout/note');
		// listing details
		me_get_template('checkout/order-details', array('cart_items' => $cart_items));
		// seller information
		me_get_template('checkout/seller-info');
		// payment gateways
		me_get_template('checkout/payment-gateways');
		?>
	</form>
</div>
