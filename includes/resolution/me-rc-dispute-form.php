<?php

/**
* MarketEngine Dispute Form Class
*
* @author 		EngineThemes
* @package 		MarketEngine/Includes
*/
class ME_Dispute_Form {
	public static function init() {
		add_action('wp_loaded', 'open_dispute_case');
	}

	public static function open_dispute_case() {

	}
}