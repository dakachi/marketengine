<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ME Authentication Form
 *
 * Class control user data in authentication form
 *
 * @version     1.0
 * @package     Includes/Authentication
 * @author      Dakachi
 * @category    Class
 */
class ME_Submit_Listing_Form extends ME_Form {
    /**
     * The single instance of the class.
     *
     * @var ME_Auth_Form
     * @since 1.0
     */
    protected static $_instance = null;

    /**
     * Main ME_Auth_Form Instance.
     *
     * Ensures only one instance of ME_Auth_Form is loaded or can be loaded.
     *
     * @since 1.0
     * @return ME_Auth_Form - Main instance.
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
        add_action('wp_loaded', array(&$this, 'process_register'));
        add_action('wp_loaded', array(&$this, 'process_forgot_pass'));
        add_action('wp_loaded', array(&$this, 'process_reset_pass'));
        add_action('wp_loaded', array(&$this, 'process_activate_email'));
    }
}