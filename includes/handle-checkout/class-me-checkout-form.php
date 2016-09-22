<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Checkout_Form
{
    public static function init_hook()
    {
        add_action('wp_loaded', array(__CLASS__, 'add_to_cart'));
        add_action('wp_loaded', array(__CLASS__, 'process_checkout'));
        // parse_request
        add_action('wp_loaded', array(__CLASS__, 'confirm_payment'));
    }

    public static function add_to_cart()
    {
        if (isset($_POST['add_to_cart']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-add-to-cart')) {
            // kiem tra san pham co con duoc ban ko
            $listing_id = $_POST['add_to_cart'];
            $listing    = get_post($listing_id);
            // kiem tra san pham co ton tai hay ko

            // neu co the mua thi dieu huong nguoi dung den trang thanh toan
            me_add_to_cart($listing_id, $_POST['qty']);
            wp_redirect(home_url('/me-checkout'));
            exit;
        }
    }

    public static function process_checkout()
    {
        if (isset($_POST['checkout']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-checkout')) {
            $result = ME_Checkout_Handle::checkout($_POST);
            if (!$result || is_wp_error($result)) {
                me_wp_error_to_notices($result);
            } else {
                // redirect to payment gateway or confirm payment
                wp_redirect($result->transaction_url);
                exit;
            }
        }
    }

    public static function confirm_payment()
    {
        if (!empty($_GET['me-payment'])) {
            $request = sanitize_text_field( strtolower($_GET['me-payment']) );
            do_action('marketegine_' . $request , $_REQUEST);
            update_option( 'handle', 'marketegine_' . $request );
            // $paypal = ME_PPAdaptive_Request::instance();
            // $paypal->complete_payment($_REQUEST);            
        }
    }

    public static function process_contact()
    {

    }
}
ME_Checkout_Form::init_hook();
