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

	public function __construct() {
		//woocommerce_product_supports
    }

    public function get_price() {
        return get_post_meta($this->id, 'me_price', true);
    }

    public function is_downloadable() {
        return get_post_meta($this->id, 'me_is_downloadable', true);
    }

    public function is_in_stock() {
        return get_post_meta($this->id, 'me_is_in_stock', true);
    }
}