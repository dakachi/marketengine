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
<p>Dear [display_name],</p>
<p>Your listing - [link] - posted in [blogname] has a new order.</p>
<p>Here are the order’s details:</p>
<ol>
<li>Buyer Name: [buyer_name]</li>
<li>Listing: [mjob_price]</li>
<li>Total: [order_total]</li>
</ol>
<p>
For this order, the platform has deducted an amount of [commission] from your total earning of [order_price]. 
You can view your order details here: [order_link].
</p>
<p>Sincerely,<br>[blogname]</p>