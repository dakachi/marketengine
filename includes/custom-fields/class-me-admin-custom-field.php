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
		add_action('wp_loaded', array(__CLASS__, 'update'));

		add_action('me_load_cf_input', array(__CLASS__, 'load_field_input'));
		add_action('wp_ajax_me_cf_load_input_type', array(__CLASS__, 'load_field_input_ajax'));
	}

	public static function insert() {
		if( isset($_POST['insert-custom-field']) && isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-insert_custom_field') ) {
			$term_ids = isset($_POST['field_for_categories']) ? $_POST['field_for_categories'] : array();
            $_POST['count'] = count($term_ids);
			$field_id = me_cf_insert_field($_POST);

			if(is_wp_error($field_id)) {
				me_wp_error_to_notices($field_id);
			} else {

				if(isset($term_ids) && !empty($term_ids)) {
					foreach($term_ids as $key => $term_id) {
						$result = me_cf_set_field_category( $field_id, $term_id, 0);
						if(is_wp_error($result)) {
							me_wp_error_to_notices($result);
							return;
						}
					}
				}

				if($_POST['redirect']) {
					wp_redirect($_POST['redirect']);
					exit;
				}
			}
		}
	}

	public static function update() {

	}

	public static function load_field_input_ajax() {
		$options = marketengine_load_input_by_field_type($_POST);
	    wp_send_json(array(
	    	'options' => $options,
	    ));
	}

	public static function load_field_input() {
		$options = marketengine_load_input_by_field_type($_POST);
	    echo $options;
	}
}


ME_Custom_Field_Handle::init();