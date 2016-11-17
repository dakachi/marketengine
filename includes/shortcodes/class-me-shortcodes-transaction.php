<?php
class ME_Shortcodes_Transaction {
    public static function init_shortcodes() {
        add_shortcode('me_checkout_form', array(__CLASS__, 'checkout_form'));
        add_shortcode('me_confirm_order', array(__CLASS__, 'confirm_order'));
        add_shortcode('me_cancel_payment', array(__CLASS__, 'cancel_order'));
        add_shortcode('me_inquiry_form', array(__CLASS__, 'inquiry_form'));
        add_shortcode('me_message_file', array(__CLASS__, 'me_message_file'));
    }

    public static function checkout_form() {
        if (!me_is_activated_user()) {
            return __("Sorry! Only active account can buy listings. Please check mail box to activate your account.", "enginethemes");
        } elseif (is_user_logged_in()) {
            ob_start();
            me_get_template('checkout/checkout');
            $content = ob_get_clean();
            return $content;
        } else {
            return ME_Shortcodes_Auth::me_login_form();
        }
    }

    public static function confirm_order() {
        $paypal = ME_PPAdaptive_Request::instance();
        $paypal->complete_payment($_REQUEST);

        $order_id = get_query_var('order-id');
        if ($order_id) {
            $order = new ME_Order($order_id);
            ob_start();
            me_get_template('checkout/confirm', array('order' => $order));
            $content = ob_get_clean();
            return $content;
        }
    }

    public static function cancel_order() {
        $order_id = get_query_var('order-id');
        if ($order_id) {
            $order = new ME_Order($order_id);
            ob_start();
            me_get_template('checkout/cancel-payment', array('order' => $order));
            $content = ob_get_clean();
            return $content;
        }
    }

    public static function inquiry_form() {
        $user_id = get_current_user_id();

        if (!$user_id) {
            return ME_Shortcodes_Auth::me_login_form();
        }

        if (!empty($_GET['inquiry_id'])) {
            $inquiry_id = $_GET['inquiry_id'];
            $inquiry    = me_get_message($inquiry_id);

            if ($user_id != $inquiry->sender && $user_id != $inquiry->receiver) {
                return load_template(get_404_template());
            }
            ob_start();
            me_get_template('inquiry/inquiry-message', array('inquiry' => $inquiry));
            $content = ob_get_clean();
            return $content;
        }

    }

    public static function me_message_file($atts) {
        if ($atts['id']) {
            $file_id = absint($atts['id']);
            if (!$file_id) {
                return;
            }
            $attached_file = get_attached_file($file_id);
            $file_name     = basename($attached_file);
            $file_size     = filesize($attached_file);
            $file_type     = wp_check_filetype($file_name);
            $file_url      = wp_get_attachment_url($file_id);

            ob_start();
            me_get_template(
                'inquiry/file-item',
                array(
                    'file_id'   => $file_id,
                    'name'      => $file_name,
                    'size'      => $file_size,
                    'file_type' => $file_type,
                    'url'       => $file_url,
                )
            );
            $content = ob_get_clean();
            return $content;
        }
    }

}
ME_Shortcodes_Transaction::init_shortcodes();