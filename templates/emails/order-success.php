<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * This is an email template
 * Email content send to seller when buyer order a listing successfull
 */
?>
<p><?php printf(__("Dear %s", "enginethemes"), $display_name); ?>,</p>
<p><?php printf(__("Your listing - %s - posted in %s has a new order.", "enginethemes"), $listing_link, get_bloginfo('blogname') ); ?></p>
<p><?php _e("Here are the order’s details:", "enginethemes"); ?></p>
<ol>
	<li><?php printf(__("Buyer Name: %s", "enginethemes"), $buyer_name) ?></li>
	<li><?php printf(__("Listing: %s", "enginethemes"), $listing_price) ?></li>
	<li><?php printf(__("Total: %s", "enginethemes"), $total) ?></li>
</ol>
<p>
<?php printf(__("For this order, the platform has deducted an amount of %s from your total earning of %s. 
You can view your order details here: %s.", "enginethemes"), $commission, $total, $order_link) ?>
</p>
<p><?php _e("Sincerely", "enginethemes"); ?>,
<br><?php get_bloginfo('blogname'); ?></p>