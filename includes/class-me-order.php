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

    }

    public function add_listing($listing, $qty = 1, $args) {
        $price = $listing->get_price();
    }

    public function update_listing($listing_id, $args) {

    }

    public function set_payment_method($payment) {

    }

    public function set_billing_address($address) {

    }
    public function set_shipping_address($address) {

    }
    public function set_payment_note($note) {

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