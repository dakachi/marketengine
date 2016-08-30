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
	<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value='dinhle1987-biz@yahoo.com'>
    <input type="hidden" name="item_name" value="Donation">
    <input type="hidden" name="item_number" value="1">
    <input type="hidden" name="amount" value="9.00">
    <input type="hidden" name="no_shipping" value="0">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="lc" value="AU">
    <input type="hidden" name="bn" value="PP-BuyNowBF">
    <input type="image" src="https://www.paypal.com/en_AU/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
    <img alt="" border="0" src="https://www.paypal.com/en_AU/i/scr/pixel.gif" width="1" height="1">
    <input type="hidden" name="return" value="http://localhost/wp/process-payment/">
    <input type="submit" value="Pay with PayPal!">
</form>
</div>
