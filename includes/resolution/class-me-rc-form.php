<?php

/**
* MarketEngine Dispute Form Class
*
* @author 		EngineThemes
* @package 		Includes/Resolution
*/
class ME_RC_Form {
	public static function init() {
		add_action('wp_loaded', array(__CLASS__, 'dispute'));
	}

	public static function dispute() {
		if(isset($_POST['me-open-dispute-case']) && isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-open_dispute_case')) {

			$case = ME_RC_Form_Handle::insert($_POST);

			if(is_wp_error($case)) {
				me_wp_error_to_notices($case);
			} else {
				$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : $_POST['_wp_http_referer'];
				wp_redirect($redirect);
				exit;
			}
		}
	}

	public static function request_close($dispute_id) {
		if (!empty($_GET['request-close']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-close_dispute')) {
			$case = ME_RC_Form_Handle::request_close($_POST['request-close']);
			if($is_wp_error( $case )) {
				me_wp_error_to_notices($case);
			}else {
				// wp_redirect($redirect);
				// exit;			
			}
		}
	}

	public static function close($dispute_id) {

	}

	public static function escalate($dispute_id) {

	}

	public static function resolve($dispute_id) {

	}
}