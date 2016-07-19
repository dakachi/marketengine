<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Order {
    public $id;
    public $order;
    public $total;
    public $shipping_info = array();
    public $items;
    /**
     *
     */
    public function __construct($order = 0) {
        $order       = absint($order);
        $this->id    = $order;
        $this->order = get_post($order);
    }

    /**
     *
     */
    public function add_listing($listing, $qty = 1, $args) {
        $item_id = me_add_order_item($this->id, $listing->get_title());
        if($item_id) {
            me_add_order_item_meta($item_id, '_listing_id', $listing);
            me_add_order_item_meta($item_id, '_listing_description', $listing->get_description());

            me_add_order_item_meta($item_id, '_qty', $qty);
            me_add_order_item_meta($item_id, '_me_price', $listing->get_price());
        }
        return $item_id;
    }

    public function update_listing($listing_id, $args) {

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

    public function set_payment_note($note) {
        update_post_meta($this->id, '_me_payment_note', $note);
    }

    public function set_payment_method($payment) {

    }

    public function get_transaction_url() {

    }

    public static function add_shipping($shipping_rate) {

    }

    public function update_shipping($item_id, $args) {

    }

    public function add_fee($fee) {

    }

    public function update_fee($item_id, $args) {

    }

    public function caculate_total() {
        // listing item total
        // shipping fee
        // order fee
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
}