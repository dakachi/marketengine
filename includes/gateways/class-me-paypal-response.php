<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNPDTAnAlternativetoIPN/
class ME_Paypal_IPN {
	/**
     * The single instance of the class.
     *
     * @var ME_Paypal_IPN
     * @since 1.0
     */
    static $_instance;
    /**
     * Main ME_Paypal_IPN Instance.
     *
     * Ensures only one instance of ME_Paypal_IPN is loaded or can be loaded.
     *
     * @since 1.0
     * @return ME_Paypal_IPN - Main instance.
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Check if paypal request on pay success
     * @author Duocnv
     */
    public function check_ipn_response() {
        ae_paypal_log("Check IPN response");
        @ob_clean();
        // Insert the post into the database
        $ipn_response = !empty($_POST) ? $_POST : FALSE;
        if ($ipn_response && $this->is_ipn_request_valid($ipn_response)) {
            header('HTTP/1.1 200 OK');
            // Create post object
            $this->request_response($ipn_response);
        } else {
            ae_paypal_log("Check IPN response invalid");
            wp_die("PayPal IPN Request Failure", "PayPal IPN", array('response' => 200));
        }

    }

    public function is_ipn_request_valid($ipn_response) {
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
        if (!is_wp_error($response) && $response['response']['code'] >= 200
            && $response['response']['code'] < 300 && strstr($response['body'], 'VERIFIED')
        ) {
            return true;
        }
        return false;
    }

    private function request_response($response) {
        $paypal = ME_Paypal_Simple::instance();
        $paypal->complete_payment($response);
    }
}

class ME_Paypal_PDT {
	/**
     * The single instance of the class.
     *
     * @var ME_Paypal_PDT
     * @since 1.0
     */
    static $_instance;
    /**
     * Main ME_Paypal_PDT Instance.
     *
     * Ensures only one instance of ME_Paypal_PDT is loaded or can be loaded.
     *
     * @since 1.0
     * @return ME_Paypal_PDT - Main instance.
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
	 
    public function handle_response() {

        $response['txn_id']      = $response['tx'];
        $response['custom']      = $response['cm'];
        $response['mc_gross']    = $response['amt'];
        $response['mc_currency'] = $response['cc'];

        $response['receiver_meail'] = $response['sig'];
        $response['payment_status'] = $response['st'];

        $this->request_response($response);
    }

    private function request_response($response) {
        $paypal = ME_Paypal_Simple::instance();
        $paypal->complete_payment($response);
    }

}

/**
 * Create log for tracking issues about PayPal checkout
 * @param string $log_content
 * @since microjobengine 1.1.2
 * @author Tat Thien
 */
function ae_paypal_log($log_content, $variable = null) {
    if (ET_DEBUG == true) {
        error_log(date('[Y-m-d H:i:s] ') . $log_content . PHP_EOL, 3, WP_CONTENT_DIR . '/et-content/' . THEME_NAME . '/paypal.log');
        if ($variable) {
            error_log(print_r($variable, true), 3, WP_CONTENT_DIR . '/et-content/' . THEME_NAME . '/paypal.log');
        }
    }
}
