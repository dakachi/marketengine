<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Order_Form {
    public static function init_hook() {
        add_action('wp_loaded', array(__CLASS__, 'process_insert'));
    }

    public static function process_insert() {
        if (!empty($_POST['add_to_cart']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-create_order')) {
            if (!is_user_logged_in()) {
            	me_add_notice(__("You must login to order listing.", "enginethemes"), 'error');
                $link = me_get_page_permalink('user-profile');
                $link = add_query_arg(array('redirect' => get_permalink()), $link);
                wp_redirect($link);
            } else {
            	//TODO: process insert order
                ME_Order_Handle::insert($_POST);
            }
        }
    }
}

ME_Order_Form::init_hook();