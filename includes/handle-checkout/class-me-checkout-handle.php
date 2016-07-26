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

        if (!$data['is_ship_to_billing_address']) {
            $shipping_add_rules = $billing_rules;
        }

        // create order
        $order = self::create_order($data);
        // need payment process payment
        $payments       = me_get_available_payments_gateways();
        $payment_method = $data['payment_method'];
        $result         = $payment[$payment_method]->process_payment($order);
        return $order;
    }

    public static function create_order($data) {
        global $user_ID;
        $data['post_author'] = $user_ID;
        $order               = me_insert_order($data);
        if (is_wp_error($order)) {
            return $order;
        }

        if (!me_is_available_payment_gateway($data['payment_method'])) {
            return new WP_Error("invalid_payment_method", __("The selected payment method is not available now.", "enginethemes"));
        }

        $listing = get_post($data['listing_id']);
        if (is_wp_error($listing)) {
            return $listing;
        }
        
        $listing = new ME_Listing($listing);
        if(!$listing->is_available()) { // TODO: Listing is not available for sale
            return new WP_Error("listing_unavailable", __("The Listing is not available for sale.", "enginethemes"));   
        }

        $order = new ME_Order($order);
        $order->add_listing($listing);
        $order->set_address($data['billing_info']);
        if (!empty($data['shipping_address'])) {
            $order->set_address($data['shipping_address'], 'shipping');
        }

        $order->set_payment_note($data['note']);
        $order->set_payment_method($data['payment_method']);

        return $order;
    }
}