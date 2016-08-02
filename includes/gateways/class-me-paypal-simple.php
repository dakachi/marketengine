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
        $api = self::get_api();
        extract($api);

        $this->_api_username = trim($api_username);
        $this->_api_endpoint = 'https://api-3t.sandbox.paypal.com/nvp';
        $this->_version      = 87.0;

        $this->_proxy    = false;
        $this->_test_mod = ae_get_option('is_test_mod');

        $this->_paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
        if ($this->_test_mod) {
            $this->_paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        }
    }

    /**
     * Function to perform the API call 3rd-Party Cart parameter
     * @param string  $nvpstr
     * @param string  $payment_type
     */
    public function set_checkout($nvpstr, $payment_type) {

        $payment_type = strtoupper($payment_type);

        if ($payment_type == 'SIMPLEPAYPAL') {

            // 2checkout url for direct purchase link using the 3rd-Party Cart parameters
            $paypal = $this->_paypal_url . "?cmd=_xclick&no_note=1&rm=2&business=" . $this->_api_username . $nvpstr;

            return $paypal;

        } else {
            return false;
        }
    }
    /**
     * Check if paypal request on pay success
     * @author Duocnv
     */
    public function check_ipn_response() {
        @ob_clean();
        // Insert the post into the database
        $ipn_response = !empty($_POST) ? $_POST : FALSE;
        if ($ipn_response && $this->check_ipn_request_is_valid($ipn_response)) {
            header('HTTP/1.1 200 OK');
            // Create post object
            $this->successful_request($ipn_response);
        } else {
            wp_die("PayPal IPN Request Failure", "PayPal IPN", array('response' => 200));
        }

    }
    /**
     * description
     * @param snippet
     * @since snippet.
     * @author Duocnv
     */
    public function successful_request($posted) {
        // Insert the post into the database
        $posted = stripslashes_deep($posted);
        if (!empty($posted['invoice'])) {
            $order_pay = new AE_Order($posted['invoice']);
            $order_pay->set_payment_code($_POST['txn_id']);
            $order_pay->set_payer_id($_POST['payer_id']);

            $posted['payment_status'] = strtolower($posted['payment_status']);
            $posted['txn_type']       = strtolower($posted['txn_type']);

            if (1 == $posted['test_ipn'] && 'pending' == $posted['payment_status']) {
                $posted['payment_status'] = 'completed';
            }
            switch ($posted['payment_status']) {
            case 'completed':
                $order_pay->set_status('publish');
                break;
            case 'pending':
                $order_pay->set_status('pending');
                break;
            case 'denied':
            case 'expired':
            case 'failed':
            case 'voided':
                $order_pay->set_status('draft');
                break;
            }

            $order_pay->update_order();

            exit;
        }
    }
    /**
     * description
     * @param snippet
     * @since snippet.
     * @author Duocnv
     */
    public function check_ipn_request_is_valid($ipn_response) {
        $validate_ipn = array('cmd' => '_notify-validate');
        $validate_ipn += stripslashes_deep($ipn_response);
        $params = array(
            'body'        => $validate_ipn,
            'sslverify'   => false,
            'timeout'     => 60,
            'httpversion' => '1.1',
            'compress'    => false,
            'decompress'  => false,
            'user-agent'  => 'AppEngine',
        );
        // Post back to get a response

        $response = wp_remote_post($this->_paypal_url, $params);
        if (!is_wp_error($response) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 && strstr($response['body'], 'VERIFIED')) {
            return true;
        }
        return false;
    }
    /**
     * @return settings array
     * @see ET_Payment::get_settings()
     */
    public function get_settings() {
        return $this->_settings;
    }
    /**
     * get paypal checkout url
     * return string : url
     */
    public function get_paypal_url() {
        return $this->_paypal_url;
    }

    public static function set_api($api = array()) {
        update_option('et_paypal_api', $api);
        if (!self::is_enable()) {
            $gateways = self::get_gateways();
            if (isset($gateways['paypal']['active']) && $gateways['paypal']['active'] != -1) {
                ET_Payment::disable_gateway('paypal');
                return __('Paypal option is disabled because of invalid setting.', ET_DOMAIN);
            }
        }
        return true;
    }

    public static function get_api() {

        $api = (array) get_option('et_paypal_api', true);
        if (!isset($api['api_username'])) {
            $api['api_username'] = '';
        }

        if (!isset($api['api_password'])) {
            $api['api_password'] = '';
        }

        if (!isset($api['api_signature'])) {
            $api['api_signature'] = '';
        }

        return $api;

    }

    // function accept visitor
    public function accept(ET_PaymentVisitor $visitor) {
        $visitor->visitSimplePaypal($this);
    }
    /**
     * check paypal api setting available or not
     */
    public static function is_enable() {
        $api = self::get_api();
        if (isset($api['api_username']) && $api['api_username'] != '') {
            return true;
        }

        return false;
    }
}