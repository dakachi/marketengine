<?php
/**
 *  The template is used to display the Checkout page when user views items in the cart
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="marketengine">
	<?php me_print_notices(); ?>
	<form method="post">
		<?php
		me_get_template_part('checkout/billing');
		// note
		me_get_template_part('checkout/note');
		// listing details
		me_get_template_part('checkout/order-details');
		// seller information
		me_get_template_part('checkout/seller-info');
		// payment gateways
		me_get_template_part('checkout/payment-gateways');
		?>
	</form>
</div>
