<?php

/**
* MarketEngine Dispute Form Class
*
* @author 		EngineThemes
* @package 		MarketEngine/Includes
*/
class ME_RC_Form {
	public static function init() {
		add_action('wp_loaded', array(__CLASS__, 'open_dispute_case'));
	}

	public static function open_dispute_case() {
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
}