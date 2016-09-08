<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function me_add_to_cart($item, $qty) {
    if (!did_action('init')) {
        _doing_it_wrong(__FUNCTION__, __('This function should not be called before wordpress init.', 'enginethemes'), '1.0');
        return;
    }
    $me_cart = ME()->session->get('me_carts', array());
    /**
     * me_add_$notice_type
     * filter notice message
     * @param String $message
     * @since 1.0
     */
    $message         = apply_filters('me_add_to_cart', $item);
    $me_cart['item'] = array($item => array('id' => $item, 'qty' => $qty));
    ME()->session->set('me_carts', $me_cart);
}

function me_get_cart_items() {
    if (!did_action('init')) {
        _doing_it_wrong(__FUNCTION__, __('This function should not be called before wordpress init.', 'enginethemes'), '1.0');
        return;
    }
    $me_cart = ME()->session->get('me_carts', array());

    if(empty($me_cart)) return false;
    /**
     * me_add_$notice_type
     * filter notice message
     * @param String $message
     * @since 1.0
     */
    return $me_cart['item'];
}