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
        } else {
            $data['shipping_address'] = $data['billing_info'];
        }
        // create order
        $order = self::create_order($data);
        return $order;
    }

    public static function pay($order) {
        $payments       = me_get_available_payment_gateways();
        $payment_method = $order->get_payment_method();
        // TODO: can dua qua trang pay/order_id de han che tinh trang gap loi khi thanh toan se tao them order moi
        $result = $payments[$payment_method]->setup_payment($order);

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

        $items = array();
        foreach ($data['listing_item'] as $key => $value) {
            $listing = get_post($value['id']);
            if (is_wp_error($listing)) {
                return new WP_Error("invalid_listing", __("The selected listing is invalid.", "enginethemes"));
            }

            $listing = new ME_Listing_Purchasion($listing);
            if (!$listing->is_available()) {
                return new WP_Error("unavailable_listing", __("The listing is not available for sale.", "enginethemes"));
            }

            if (!$value['qty']) {
                return new WP_Error("unavailable_listing", __("The listing quantity must be greater than 1.", "enginethemes"));
            }

            $items[] = array('id' => $listing, 'qty' => $value['qty']);
        }

        $order = me_insert_order($data);
        if (is_wp_error($order)) {
            return $order;
        }

        $order = new ME_Order($order);
        foreach ($items as $item) {
            $order->add_listing($item['id'], $item['qty']);
        }

        $order->set_address($data['billing_info']);
        if (!empty($data['shipping_address'])) {
            $order->set_address($data['shipping_address'], 'shipping');
        }
        $order->set_payment_method($data['payment_method']);

        return $order;
    }

    public static function inquiry($data) {

        if (empty($data['inquiry_listing'])) {
            return new WP_Error('empty_listing', __("The listing is required.", "enginethemes"));
        }

        if (empty($data['content'])) {
            return new WP_Error('empty_inquiry_content', __("The inquiry content is required.", "enginethemes"));
        }

        $id = me_get_current_inquiry($listing_id);
        // TODO: tao inquiry link voi listing dong thoi tao message, inquiry chi luu thong tin listing thoi
        if (!$id) {
            //TODO: validate listing id
            $listing_id = $data['inquiry_listing'];

            // TODO: filter the content
            $content = $data['content'];


            // create inquiry
            $result = me_insert_message(
                array(
                    'post_content' => 'Inquiry listing #' . $listing_id,
                    'post_title'   => 'Inquiry listing #' . $listing_id,
                    'post_type'    => 'inquiry',
                    'receiver'     => get_post_field('post_author', $listing_id),
                    'post_parent'  => $listing_id,
                ), true
            );

            if ($result) {
                // add message to inquiry
                me_insert_message(
                    array(
                        'post_content' => $content,
                        'post_title'   => 'Message listing #' . $listing_id,
                        'post_type'    => 'message',
                        'receiver'     => get_post_field('post_author', $listing_id),
                        'post_parent'  => $result,
                    ), true
                );
            }
        }
    }

    public static function message($data) {
        // inquiry id
        // get receiver
        // add message
    }

}
