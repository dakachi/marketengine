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
	public $instance;

	public static function get_instance() {
		if(is_null(self::$instance)) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public static function init() {
		add_action('wp_loaded', 'marketengine_add_actions');
		add_action('wp_loaded', array(__CLASS__, 'insert'));
	}

	public static function insert() {
		if( isset($_POST['insert-custom-field']) && isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-insert_custom_field') ) {
			$field_id = me_cf_insert_field($_POST);

			if(is_wp_error($field_id)) {
				me_wp_error_to_notices($field_id);
			} else {
				if($_POST['redirect']) {
					wp_redirect($_POST['redirect']);
					exit;
				}
			}
		}
	}
}

ME_Custom_Field_Handle::init();