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
        // item list
        // billing details
        // shipping details
        // update user billing details
        // payment gateway
        // create order
        $order = self::create_order($data);
        // need payment process payment
        $payments = me_get_available_payments_gateways();
        $payment_method = $data['payment_method'];
        $result = $payment[$payment_method]->process_payment($order);
        return $order;
    }

    public static function create_order($data) {
        $order = me_insert_order($data);
        if (is_wp_error($order)) {
            return $order;
        }

        $order = new ME_Order($order);
        $order->add_listing($data['listing_id']);
        $order->set_billing_address($data['address']);
        $order->add_shipping('flat_rate');
        $order->set_shipping_address($data['shipping_address']);
        $order->set_payment_note($data['note']);
        $order->set_payment_method($data['payment_method']);

        return $order;
    }
}