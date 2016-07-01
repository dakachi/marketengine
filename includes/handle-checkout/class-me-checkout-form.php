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
    	if(isset($_POST['checkout']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-checkout') ) {
    		ME_Checkout_Handle::checkout($_POST);	
    	}        
    }    
}

ME_Checkout_Form::init_hook();