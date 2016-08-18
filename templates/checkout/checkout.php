<?php
/**
 *  The template is used to display the Checkout page when user views items in the cart
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// listing details
me_get_template_part('checkout/listing-details');
// seller information
me_get_template_part('checkout/seller-info');
// note
me_get_template_part('checkout/note');
// payment gateways
me_get_template_part('checkout/payment-gateways');