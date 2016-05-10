<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class ME_Listing {

	public $id;
	public $post;
	public $listing_type; // contact, purchase, rental
	public $stock;
	public $shipping;
	/**
     * The single instance of the class.
     *
     * @var ME_Listing
     * @since 1.0
     */
    protected static $_instance = null;

    /**
     * Main ME_Listing Instance.
     *
     * Ensures only one instance of ME_Listing is loaded or can be loaded.
     *
     * @since 1.0
     * @return ME_Listing - Main instance.
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

	public function __construct() {
		//woocommerce_product_supports
    }
}