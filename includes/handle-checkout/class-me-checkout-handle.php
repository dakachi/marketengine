<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * ME_Order_Handle
 *
 * Handling buyer order order behavior
 *
 * @class       ME_Order_Handle
 * @version     1.0
 * @package     Includes/Orders
 * @author      EngineThemesTeam
 * @category    Class
 */
class ME_Checkout_Handle {
    public static function checkout($data) {
        $rules = array(
            'listing_id'     => 'required|numeric',
            'payment_method' => 'required|string',
            'billing_info'   => 'required|array',
        );

        $billing_rules = array(
            'first_name' => 'required',
            'last_name'  => 'required',
            'phone'      => 'required|numeric',
            'email'      => 'required|email',
            'postcode'   => 'string',
            'address'    => 'required|string',
            'city'       => 'required',
            'country'    => 'required',
        );

        if (!empty($data['is_ship_to_billing_address'])) {
            $shipping_rules = $billing_rules;
        }else {
            $data['shipping_address'] =  $data['billing_info'];
        }
        // create order
        $order = self::create_order($data);
        if(is_wp_error( $order )) {
            return $order;
        }

        $payments       = me_get_available_payment_gateways();
        $payment_method = $data['payment_method'];
        $result         = $payments[$payment_method]->setup_payment($order);

        return $result;
    }

    /**
     * Handle order data and store to database
     * 
     * @param array $data
     *
     * @since 1.0
     * @return WP_Error | ME_Order
     */
    public static function create_order($data) {
        global $user_ID;
        $data['post_author'] = $user_ID;

        if (empty($data['payment_method']) || !me_is_available_payment_gateway($data['payment_method'])) {
            return new WP_Error("invalid_payment_method", __("The selected payment method is not available now.", "enginethemes"));
        }

        $listing = get_post($data['listing_id']);
        if (is_wp_error($listing)) {
            return new WP_Error("invalid_listing", __("The selected listing is invalid.", "enginethemes"));
        }

        $listing = new ME_Listing_Purchasion($listing);
        if (!$listing->is_available()) {
            return new WP_Error("unavailable_listing", __("The listing is not available for sale.", "enginethemes"));
        }

        $order = me_insert_order($data);
        if (is_wp_error($order)) {
            return $order;
        }

        $order = new ME_Order($order);
        $order->add_listing($listing);
        $order->set_address($data['billing_info']);
        if (!empty($data['shipping_address'])) {
            $order->set_address($data['shipping_address'], 'shipping');
        }
        $order->set_payment_method($data['payment_method']);

        return $order;
    }
}