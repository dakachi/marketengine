<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Paypal_Simple extends ME_Payment {

    /**
     * The single instance of the class.
     *
     * @var ME_Paypal_Simple
     * @since 1.0
     */
    static $_instance;

    /**
     * @var string $_api_endpoint The server URL which you have to connect for submitting your API request.
     * @since 1.0
     */
    protected $_api_endpoint;

    /**
     * Version: this is the API version in the request.
     * It is a mandatory parameter for each API request.
     * The only supported value at this time is 2.3
     */
    protected $_version;

    /**
     * @var string $_paypal_url The URL that the buyer is first sent to to authorize payment with their paypal account change the URL depending if you are testing on the sandbox
     * or going to the live PayPal site
     * @since 1.0
     */
    protected $_paypal_url;

    /**
     * Main ME_Paypal_Simple Instance.
     *
     * Ensures only one instance of ME_Paypal_Simple is loaded or can be loaded.
     *
     * @since 1.0
     * @return ME_Paypal_Simple - Main instance.
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        $api = ae_get_option('simple_paypal_api', array());

        $this->receiver_email = trim($api['receiver_email']);
        $this->_api_endpoint  = 'https://api-3t.sandbox.paypal.com/nvp';

        $this->_proxy    = false;
        $this->_test_mod = ae_get_option('is_test_mod');

        $this->_paypal_url = 'https://www.paypal.com/cgi-bin/webscr?';
        if ($this->_test_mod) {
            $this->_paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?';
        }
    }

    /**
     * Function to perform the API call 3rd-Party Cart parameter
     *
     * @param array  $order
     * 
     * @since 1.0
     * @return string
     */
    public function set_checkout($order) {
        // 2checkout url for direct purchase link using the 3rd-Party Cart parameters
        $paypal = $this->_paypal_url . $this->build_query($order);
        return $paypal;
    }

    public function build_query($order_data) {
        return http_build_query($order_data);
    }

    public function setup_payment($order) {}
    public function process_payment($order){}
    public function refund($order){}
}