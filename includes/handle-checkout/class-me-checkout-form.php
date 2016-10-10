<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Checkout_Form {
    public static function init_hook() {
        add_action('wp_loaded', array(__CLASS__, 'add_to_cart'));
        add_action('wp_loaded', array(__CLASS__, 'process_contact'));
        add_action('wp_loaded', array(__CLASS__, 'process_checkout'));
        // parse_request
        add_action('wp_loaded', array(__CLASS__, 'confirm_payment'));
        add_action('wp_loaded', array(__CLASS__, 'send_inquiry'));
    }

    public static function confirm_payment() {
        if (!empty($_GET['me-payment'])) {
            $request = sanitize_text_field(strtolower($_GET['me-payment']));
            do_action('marketegine_' . $request, $_REQUEST);
        }
    }

    public static function add_to_cart() {
        if (isset($_POST['add_to_cart']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-add-to-cart')) {
            // kiem tra san pham co con duoc ban ko
            $listing_id = $_POST['add_to_cart'];
            $listing    = get_post($listing_id);
            // kiem tra san pham co ton tai hay ko

            // neu co the mua thi dieu huong nguoi dung den trang thanh toan
            me_add_to_cart($listing_id, $_POST['qty']);
            wp_redirect(me_get_page_permalink('checkout'));
            exit;
        }
    }

    public static function process_checkout() {
        if (isset($_POST['checkout']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-checkout')) {
            $order = ME_Checkout_Handle::checkout($_POST);
            if (!$order || is_wp_error($order)) {
                me_wp_error_to_notices($order);
            } else {
                me_empty_cart();
                // redirect to payment gateway or confirm payment
                self::process_pay($order);

            }
        }
        // TODO: update order function
        if (isset($_POST['order_id']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-pay')) {
            $order = new ME_Order($_POST['order_id']);
            self::process_pay($order);            
        }
    }

    public static function process_pay($order) {
        $result = ME_Checkout_Handle::pay($order);
        if (!$result || is_wp_error($result)) {
            me_wp_error_to_notices($result);
            // TODO: update link nay
            wp_redirect(home_url('/me-checkout/pay/' . $order->id));
            exit;
        } else {
            wp_redirect($result->transaction_url);
            exit;
        }
    }

    public static function process_contact() {
        if (isset($_POST['send_inquiry']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-send-inquiry')) {
            $redirect = me_get_page_permalink('inquiry');
            //TODO: kiem tra giua 2 user da co inquiry chua, tra ve id va dieu huong den trang inquiry
            $id = me_get_current_inquiry($_POST['send_inquiry']);
            if (!$id) {
                $redirect = add_query_arg(array('id' => $_POST['send_inquiry']), $redirect);
                wp_redirect($redirect);
                exit;
            } else {
                $redirect = add_query_arg(array('id' => $id), $redirect);
                wp_redirect($redirect);
                exit;
            }
        }
    }

    public static function send_inquiry() {
        if (isset($_POST['content']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-post-inquiry')) {
            $result = ME_Checkout_Handle::inquiry($_POST);
            if (is_wp_error($result)) {
                me_wp_error_to_notices($result);
            } else {
                $redirect = me_get_page_permalink('inquiry');
                $redirect = add_query_arg(array('id' => $_POST['inquiry_listing']), $redirect);
                wp_redirect($redirect);
                exit;
            }
        }
    }

}
ME_Checkout_Form::init_hook();