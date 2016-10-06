<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Order {
    public $id;
    public $order;
    public $subtotal;
    public $total;
    public $shipping_info = array();
    public $items         = array();
    /**
     *
     */
    public function __construct($order = 0) {
        if(is_numeric($order)) {
            $order       = absint($order);
            $this->id    = $order;
            $this->order = get_post($order);
        }else {
            $this->order = $order;
            $this->id = $order->ID;
        }
        $this->caculate_subtotal();
        $this->caculate_total();
    }

    public function __get($name) {
        if(strrpos($name, 'billing') !== false ) {
            $billing_address = $this->get_address('billing');
            $name = str_replace('billing_', '', $name);
            if(isset($billing_address[$name])) {
                return $billing_address[$name];
            }else {
                return '';
            }
        }

        if(strrpos($name, 'shipping') !== false ) {
            $shipping = $this->get_address('shipping');
            $name = str_replace('shipping_', '', $name);
            if(isset($shipping[$name])) {
                return $shipping[$name];
            }else {
                return '';
            }
        }

        return '';
    }

    public function has_status($status) {
        return $this->order->post_status === $status;
    }

    public function get_confirm_url() {
        $page = me_get_page_permalink( 'confirm_order' );
        $order_endpoint = me_get_endpoint_name('order-id');
        return $page .$order_endpoint. '/' . $this->id;
    }

    public function get_transaction_detail_url() {
        $page = me_get_page_permalink( 'transaction_detail' );
        $order_endpoint = me_get_endpoint_name('transaction-id');
        return $page .$order_endpoint. '/' . $this->id;
    }

    public function get_cancel_url() {
        // TODO: rewrite this url
        return 'http://localhost/wp/cancel-payment/order/' . $this->id;
    }

    /**
     * Retrieve Order Currency
     * @return String
     * @since 1.0
     */
    public function get_currency() {
        return 'USD';
    }

    public function get_receiver_email() {
        return 'dinhle1987-biz@yahoo.com';
    }
    /**
     * Add listing item to order details
     *
     * @param ME_Listing $listing The listing object
     * @param int $qty
     *
     * @since 1.0
     * @return int|bool Return order item id if sucess, if not success return false
     */
    public function add_listing($listing, $qty = 1) {
        if (!is_object($listing)) {
            return false;
        }

        $order_item_id = me_add_order_item($this->id, $listing->get_title(), 'listing_item');
        if ($order_item_id) {
            me_add_order_item_meta($order_item_id, '_listing_id', $listing->id);
            me_add_order_item_meta($order_item_id, '_listing_description', $listing->get_description());

            me_add_order_item_meta($order_item_id, '_qty', $qty);
            me_add_order_item_meta($order_item_id, '_listing_price', $listing->get_price());
        }

        $this->caculate_subtotal();
        $this->caculate_total();

        return $order_item_id;
    }
    /**
     * Update listing item
     *
     * @param int $item_id The order item id
     * @param ME_Listing $listing The listing object
     * @param array $args
     *
     * @since 1.0
     */
    public function update_listing($item_id, $listing, $args) {
        $item_id = absint($item_id);

        if (!$item_id) {
            return false;
        }

        if (isset($args['qty'])) {
            me_update_order_item_meta($item_id, '_qty', $args['qty']);
        }

        $this->caculate_subtotal();
        $this->caculate_total();

        return $item_id;
    }

    /**
     * Add receiver to order details
     *
     * @param ME_User $receiver The ME user object
     *
     * @since 1.0
     * @return int|bool Return order item id if sucess, if not success return false
     */
    public function add_receiver($receiver) {
        if (!is_object($receiver)) {
            return false;
        }

        $order_item_id = me_add_order_item($this->id, $receiver->user_name, 'receiver_item');
        if ($order_item_id) {
            me_add_order_item_meta($order_item_id, '_receive_email', $receiver->email);
            me_add_order_item_meta($order_item_id, '_is_primary', $receiver->is_primary);
            me_add_order_item_meta($order_item_id, '_amount', $receiver->amount);
        }
        return $order_item_id;
    }

    /**
     * Update receiver item
     *
     * @param int $item_id The order item id
     * @param ME_User $receiver The ME user object
     *
     * @since 1.0
     * @return int|bool Return order item id if sucess, if not success return false
     */
    public function update_receiver($item_id, $receiver) {
        $order_item_id = absint($item_id);

        if (!$order_item_id) {
            return false;
        }

        me_update_order_item_meta($order_item_id, '_receive_email', $receiver->get_receiver_email());
        me_update_order_item_meta($order_item_id, '_is_primary', $receiver->is_primary());
        me_update_order_item_meta($order_item_id, '_amount', $receiver->get_amount());

        return $order_item_id;
    }

    /**
     * Get order address
     *
     * @param string $type The address type
     *
     * @since 1.0
     *
     * @return array Array of address details
     */
    public function get_address($type = 'billing') {
        $address_fields = array('first_name', 'last_name', 'phone', 'email', 'postcode', 'address', 'city', 'country');
        $address       = array();
        foreach ($address_fields as $field) {
            $address[$field] = get_post_meta($this->id, '_me_' . $type . '_' . $field, true);
        }
        return $address;
    }

    /**
     * Set order address
     *
     * @param array $address The address details
     * @param string $type The address type
     *
     * @since 1.0
     *
     * @return array Array of address details
     */
    public function set_address($address, $type = 'billing') {
        $address_fields = array('first_name', 'last_name', 'phone', 'email', 'postcode', 'address', 'city', 'country');
        foreach ($address_fields as $field) {
            if (isset($address[$field])) {
                update_post_meta($this->id, '_me_' . $type . '_' . $field, $address[$field]);
            }
        }
    }

    public function add_shipping($shipping_name) {
        update_post_meta($this->id, '_shipping_method', $shipping_name);
        $this->shipping_info['name'] = $shipping_name;
        $this->caculate_total();
    }

    public function update_shipping($item_id, $args) {

    }

    /**
     * Add order fee
     * @param array $fee
     *  - name The fee name
     *  - title The fee title
     *  - amount The amount of fee
     *
     * @since 1.0
     * @return int
     */
    public function add_fee($fee) {
        $item_id = me_add_order_item($this->id, $fee['name'], '_order_fee');
        if ($item_id) {
            me_add_order_item_meta($item_id, '_fee_amount', $fee['amount']);
            me_add_order_item_meta($item_id, '_fee_title', $fee['title']);
        }
        $this->caculate_total();
        return $item_id;
    }

    /**
     * Add order fee
     *
     * @param int $item_id The fee item id want to update
     * @param array $fee
     *  - name The fee name
     *  - title The fee title
     *  - amount The amount of fee
     *
     * @since 1.0
     * @return int
     */
    public function update_fee($item_id, $args) {
        if (!empty($args['name'])) {
            me_update_order_item($item_id, array('order_item_name' => $args['name']));
        }

        $fee_attrs = array('title', 'amount');
        foreach ($fee_attrs as $fee_attr) {
            if (!empty($args[$fee_attr])) {
                me_update_order_item_meta($item_id, '_fee_' . $fee_attr, $args[$fee_attr]);
            }
        }

        $this->caculate_total();
        return $item_id;
    }

    /**
     * Calculate the total amount of product in the order
     *
     * @since 1.0
     * @return int
     */
    public function caculate_subtotal() {
        $listing_items = me_get_order_items($this->id, 'listing_item');
        $subtotal      = 0;

        foreach ($listing_items as $key => $item) {
            $price = me_get_order_item_meta($item->order_item_id, '_listing_price', true);
            $qty   = me_get_order_item_meta($item->order_item_id, '_qty', true);
            $subtotal += $price * $qty;
        }

        $this->subtotal = $subtotal;
        update_post_meta($this->id, '_order_subtotal', $subtotal);
        return $this->subtotal;
    }

    public function caculate_fee() {
        return 0;
    }

    /**
     * Calculate the total shipping cost of order
     *
     * @since 1.0
     * @return double
     */
    public function caculate_shipping() {
        if (!empty($this->shipping_info['name'])) {
            $shipping_class = me_get_shipping_class($this->shipping_info['name'], $this);
            return $shipping_class->caculate_fee();
        }
        return 0;
    }

    /**
     * Caculate order total: subtotal, shipping fee, order fee
     * @since 1.0
     * @return double
     */
    public function caculate_total() {
        $this->shipping_fee = $this->caculate_shipping();
        $this->payment_fee  = $this->caculate_fee();
        $this->total        = $this->subtotal + $this->shipping_fee + $this->payment_fee;

        update_post_meta($this->id, '_order_total', $this->total);
        return $this->total;
    }

    public function get_total() {
        return get_post_meta($this->id, '_order_total', true);
    }

    /**
     * Retrieve the order transaction id
     * @since 1.0
     * @return string
     */
    public function get_transaction_id() {
        return get_post_meta($this->id, '_me_transation_id', true);
    }

    /**
     * Retrieve the payment key associated with the payment in payment gateway
     * @since 1.0
     * @return string
     */
    public function get_payment_key() {
        return get_post_meta($this->id, '_me_payment_key', true);
    }

    public function get_order_details() {

    }

    public function get_order_number() {
        return $this->id;
    }

    public function get_buyer() {

    }

    public function get_payment_info() {

    }

    public function set_payment_method($payment) {
        if (is_object($payment)) {
            update_post_meta($this->id, '_me_payment_gateway', $payment->name);
            update_post_meta($this->id, '_me_gateway_title', $payment->title);
        } else {
            update_post_meta($this->id, '_me_payment_gateway', '');
            update_post_meta($this->id, '_me_gateway_title', '');
        }
    }

    public function get_payment_method() {
        return get_post_meta($this->id, '_me_payment_gateway', true);
    }

    public function get_transaction_url() {

    }

}