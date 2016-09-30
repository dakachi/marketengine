<?php
class ME_Shortcodes_Listing {
    public static function init_shortcodes() {
        add_shortcode('me_post_listing_form', array(__CLASS__, 'post_listing_form'));
        add_shortcode('me_listings', array(__CLASS__, 'the_listing'));
        add_shortcode('me_checkout_form', array(__CLASS__, 'checkout_form'));
        add_shortcode('me_confirm_order', array(__CLASS__, 'confirm_order'));
        add_shortcode('me_inquiry_form', array(__CLASS__, 'inquiry_form'));
    }
    public static function post_listing_form() {
    	ob_start();
        me_get_template('post-listing/post-listing');
        $content = ob_get_clean();
        return $content;
    }

    public static function the_listing() {
    	ob_start();
        me_get_template('taxonomy-listing_cat');
        $content = ob_get_clean();
        return $content;
    }

    public static function checkout_form() {
        ob_start();
        me_get_template('checkout/checkout');
        $content = ob_get_clean();
        return $content;
    }

    public static function confirm_order() {
        $paypal = ME_PPAdaptive_Request::instance();
        $paypal->complete_payment($_REQUEST);

        $order_id = get_query_var( 'order-id' );
        if($order_id) {
            $order = new ME_Order($order_id);
            ob_start();
            me_get_template('checkout/confirm', array('order' => $order));
            $content = ob_get_clean();
            return $content;
        }
    }


    public static function inquiry_form() {
        $listing_id = $_GET['id'];
        $listing  = get_post($listing_id);
        if($listing) {
            $listing = new ME_Listing_Contact($listing);
        }
        ob_start();
        me_get_template('inquiry/inquiry', array('listing' => $listing));
        $content = ob_get_clean();
        return $content;
    }

}
ME_Shortcodes_Listing::init_shortcodes();