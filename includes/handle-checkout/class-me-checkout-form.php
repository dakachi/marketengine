<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Checkout_Form {
    public static function init_hook() {
        add_action('wp_loaded', array(__CLASS__, 'process_checkout'));
    }

    public static function process_checkout() {
        ME_Checkout_Handle::checkout();
    }    
}

ME_Checkout_Form::init_hook();