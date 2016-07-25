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
    public $items = array();
    /**
     *
     */
    public function __construct($order = 0) {
        $order       = absint($order);
        $this->id    = $order;
        $this->order = get_post($order);
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
     * Get order address
     *
     * @param string $type The address type
     *
     * @since 1.0
     *
     * @return array Array of address details
     */
    public function get_address($type = 'billing') {
        $address_field = array('first_name', 'last_name', 'phone', 'email', 'postcode', 'address', 'city', 'country');
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
        $address_field = array('first_name', 'last_name', 'phone', 'email', 'postcode', 'address', 'city', 'country');
        foreach ($address_fields as $field) {
            if (isset($address[$field])) {
                update_post_meta($this->id, '_me_' . $type . '_' . $field, $address[$field]);
            }
        }
    }

    public static function add_shipping($shipping_rate) {
        $this->caculate_total();
    }

    public function update_shipping($item_id, $args) {

    }

    public function add_fee($fee) {

    }

    public function update_fee($item_id, $args) {

    }

    public function caculate_subtotal(){
        $listing_items = me_get_order_items($this->id, 'listing_item');
        $subtotal = 0;

        foreach ($listing_items as $key => $item) {
            $price = me_get_order_item_meta($item->order_item_id, '_listing_price', true);
            $qty = me_get_order_item_meta($item->order_item_id, '_qty', true);
            $subtotal += $price * $qty;
        }

        $this->subtotal = $subtotal;
        update_post_meta($this->id, '_order_subtotal', $subtotal);
        return $this->subtotal;
    }

    public function caculate_shipping() {
        return 0;
    }

    public function caculate_total() {
        $this->shipping_fee = $this->caculate_shipping();
        $this->payment_fee = 0;
        $this->total  = $this->subtotal + $this->shipping_fee + $this->payment_fee;
        update_post_meta( $this->id, '_order_total', $this->total);
        return $this->total;
    }

    public function get_transaction_id() {
        return get_post_meta($this->id, '_me_transation_id', true);
    }

    public function get_order_details() {

    }

    public function get_buyer() {

    }

    public function get_payment_info() {

    }

    public function set_payment_method($payment) {
        update_post_meta($this->id, '_me_payment_gateway', $payment->name);
        update_post_meta($this->id, '_me_gateway_title', $payment->title);
    }

    public function get_transaction_url() {

    }
}