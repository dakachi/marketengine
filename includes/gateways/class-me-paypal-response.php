<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNPDTAnAlternativetoIPN/
class ME_Paypal_IPN {
	// https://www.paypal.com/us/cgi-bin/webscr?cmd=p/acc/ipn-info-outside
	/**
     * Check if paypal request on pay success
     * @author Duocnv
     */
    public function check_ipn_response ()
    {
	    ae_paypal_log("Check IPN response");
        @ob_clean();
        // Insert the post into the database
        $ipn_response = !empty( $_POST ) ? $_POST : FALSE;
        if ( $ipn_response && $this->check_ipn_request_is_valid( $ipn_response ) ) {
            header( 'HTTP/1.1 200 OK' );
            // Create post object
            $this->successful_request($ipn_response);
        } else {
	        ae_paypal_log("Check IPN response invalid");
            wp_die( "PayPal IPN Request Failure", "PayPal IPN", array ( 'response' => 200 ) );
        }

    }

    function check_ipn_request_is_valid ( $ipn_response )
    {
        $validate_ipn = array( 'cmd' => '_notify-validate' );
        $validate_ipn += stripslashes_deep( $ipn_response );
        $params = array(
            'body' 			=> $validate_ipn,
            'sslverify' 	=> false,
            'timeout' 		=> 60,
            'httpversion'   => '1.1',
            'compress'      => false,
            'decompress'    => false,
            'user-agent'	=> 'AppEngine'
        );
        // Post back to get a response

        $response = wp_remote_post( $this->_paypal_url, $params );
        if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 && strstr( $response['body'], 'VERIFIED' ) ) {
            return true;
        }
        return false;
    }

	private function check_payment_status() {

	}

	private function check_txn_id() {

	}

	private function check_receiver_email() {

	}

	private function check_mc_gross() {

	}

	private function check_currency() {

	}
}

// https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNandPDTVariables/#id092BE0U605Z
class ME_Paypal_PDT {
	
	//cm : custom message
	//sig : 
	
	private function check_payment_status() {
		$response['st']
	}

	private function check_txn_id() {
		$response['tx']
	}

	private function check_receiver_email() {
		$response['sig']
	}

	private function check_mc_gross() {
		$response['amt']
	}

	private function check_currency() {
		$response['cc']
	}
}

/**
 * Create log for tracking issues about PayPal checkout
 * @param string $log_content
 * @since microjobengine 1.1.2
 * @author Tat Thien
 */
function ae_paypal_log($log_content, $variable = null) {
    if(ET_DEBUG == true) {
        error_log(date('[Y-m-d H:i:s] '). $log_content . PHP_EOL, 3, WP_CONTENT_DIR . '/et-content/' . THEME_NAME . '/paypal.log');
        if($variable) {
            error_log(print_r($variable, true), 3, WP_CONTENT_DIR . '/et-content/' . THEME_NAME . '/paypal.log');
        }
    }
}
