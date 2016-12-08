<?php
/**
 * MarketEngine Custom Field Handle
 *
 * @author  EngineThemes
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Class MarketEngine Custom Field Handle
 * Handle MarketEngine Custom Field in post, edit listing form and listing details
 *
 * @package Includes/CustomFields
 * @category Class
 *
 * @since 	1.0.1
 * @version 1.0.0
 */

class ME_Custom_Field_Handle {
	public function __construct() {
		add_action('wp_loaded', 'marketengine_add_actions');
		add_action('wp_loaded', array($this, 'insert'));
	}

	public static function insert() {
		if( isset($_POST['insert-custom-field']) && isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-insert_custom_field') ) {
			// Insert field
		}
	}
}

new ME_Custom_Field_Handle();