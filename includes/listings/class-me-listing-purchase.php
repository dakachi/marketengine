<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class ME_Listing_Purchase extends ME_Listing{
    /**
     * @var int $stock
     * the number of good regularly available for sale.
     */
    public $stock;
    /**
     * @var double $price
     */
    public $price;
    /**
     * @var array $shipping
     * shipping fee info
     */
    public $shipping;
	/**
     * The single instance of the class.
     *
     * @var ME_Listing
     * @since 1.0
     */

    public function get_price() {
        return get_post_meta($this->id, 'listing_price', true);
    }

    public function get_pricing_unit() {
        $pricing_text = array(
            '0' => '',
            'none' => '',
            'per_unit' => __("/Unit", "enginethemes"),
            'per_hour' => __("/Hour", "enginethemes")
        );
        return $pricing_text[get_post_meta($this->id, 'pricing_unit', true)];   
    }

    public function is_downloadable() {
        return get_post_meta($this->id, 'me_is_downloadable', true);
    }

    public function is_in_stock() {
        return get_post_meta($this->id, 'me_is_in_stock', true);
    }
}