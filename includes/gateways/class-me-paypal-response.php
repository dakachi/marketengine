<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNPDTAnAlternativetoIPN/
class ME_Paypal_IPN {
	private $_paypal_url;
	public function __construct() {
		$this->_test_mod = ae_get_option('is_test_mod', true);
        $this->_paypal_url = 'https://www.paypal.com/cgi-bin/webscr?';
        if ($this->_test_mod) {
            $this->_paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?';
        }
	}
    // https://www.paypal.com/us/cgi-bin/webscr?cmd=p/acc/ipn-info-outside
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

// https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNandPDTVariables/#id092BE0U605Z
class ME_Paypal_PDT {

    //cm : custom message
    //sig :


	public function handle_response() {
		$response['payment_status'] = $response['st'];
		$response['txn_id'] = $response['tx'];
		$response['receiver_meail'] = $response['sig'];
		$response['custom'] = $response['cm'];
		$response['mc_gross'] = $response['amt'];
		$response['mc_currency'] = $response['cc'];
		
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
