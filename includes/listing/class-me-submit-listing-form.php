<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ME Submit Listing Form
 *
 * Class control listing data in listing form
 *
 * @version     1.0
 * @author      Dakachi
 * @package     Includes/Listing
 * @category    Class
 */
class ME_Submit_Listing_Form extends ME_Form {
    /**
     * The single instance of the class.
     *
     * @var ME_Submit_Listing_Form
     * @since 1.0
     */
    protected static $_instance = null;

    /**
     * Main ME_Submit_Listing_Form Instance.
     *
     * Ensures only one instance of ME_Submit_Listing_Form is loaded or can be loaded.
     *
     * @since 1.0
     * @return ME_Submit_Listing_Form - Main instance.
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {

    }

    public function add_action() {
        add_action('wp_loaded', array(&$this, 'process_login'));
    }
}