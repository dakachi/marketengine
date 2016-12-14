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
		add_action('wp_loaded', array(__CLASS__, 'delete'));
		add_action('wp_loaded', array(__CLASS__, 'remove_from_category'));

		add_action('me_load_cf_input', array(__CLASS__, 'load_field_input'));
		add_action('wp_ajax_me_cf_load_input_type', array(__CLASS__, 'load_field_input_ajax'));
		add_action('wp_ajax_check_field_name', array(__CLASS__, 'check_field_name'));
	}

	public static function insert() {
		if( is_admin() && isset($_POST['insert-custom-field']) && isset($_REQUEST['view']) && ($_REQUEST['view'] == 'add' || $_REQUEST['view'] == 'edit' ) && isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-insert_custom_field') ) {
			$term_ids = isset($_POST['field_for_categories']) ? $_POST['field_for_categories'] : array();
            $_POST['count'] = count($term_ids);

            $attributes = self::filter_field_attribute();
            $_POST['field_constraint'] = $attributes;

            if($_REQUEST['view'] == 'add') {
				$field_id = me_cf_insert_field($_POST, true);
            } else {
            	$_POST['field_id'] = $_REQUEST['custom-field-id'];
            	$current_cats = me_cf_get_affected_categories($_REQUEST['custom-field-id']);
            	self::remove_categories(array(
            		'field_id'		=> $_POST['field_id'],
            		'current_cats' => $current_cats,
            		'new_cats'	=> $term_ids,
            	));

            	$field_id = me_cf_update_field($_POST, true);
            }

			if(is_wp_error($field_id)) {
				me_wp_error_to_notices($field_id);
			} else {
				$result = self::set_field_category($field_id, $term_ids);
				if(is_wp_error($result)) {
					me_wp_error_to_notices($result);
					return;
				}

				if($_POST['redirect']) {
					wp_redirect($_POST['redirect']);
					exit;
				}
			}
		}
	}

	public static function delete() {
		if(is_admin() && isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete-custom-field' && isset($_REQUEST['_wp_nonce']) && wp_verify_nonce($_REQUEST['_wp_nonce'], 'delete-custom-field') && isset($_REQUEST['custom-field-id'])) {
			$result = me_cf_delete_field($_REQUEST['custom-field-id']);
			if(is_wp_error($result)) {
				me_wp_error_to_notices($field_id);
				return;
			}

			$redirect = remove_query_arg(array('action', '_wp_nonce', 'custom-field-id'));
			wp_redirect($redirect);
			exit;
		}
	}

	public static function remove_from_category() {
		if(is_admin() && isset($_REQUEST['action']) && $_REQUEST['action'] == 'remove-from-category' && isset($_REQUEST['_wp_nonce']) && wp_verify_nonce($_REQUEST['_wp_nonce'], 'remove-from-category') && isset($_REQUEST['custom-field-id'])) {

			me_cf_remove_field_category($_REQUEST['custom-field-id'], $_REQUEST['category-id']);

			$redirect = remove_query_arg(array('action', '_wp_nonce', 'custom-field-id'));
			wp_redirect($redirect);
			exit;
		}
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

	public static function set_field_category($field_id, $term_ids) {
		if(isset($term_ids) && !empty($term_ids)) {
			foreach($term_ids as $key => $term_id) {
				$result = me_cf_set_field_category( $field_id, $term_id, 0);
			}
		} else {
			$result = new WP_Error('invalid_taxonomy', __('Categories is required!', 'enginethemes'));
		}
		return $result;
	}

	public static function remove_categories($args) {
		extract($args);
		$unuse_cats = array_diff($current_cats, $new_cats);

		foreach ($unuse_cats as $key => $cat) {
    		$removed = me_cf_remove_field_category($field_id, $cat);
	    	if(is_wp_error($removed)) {
	    		me_wp_error_to_notices($removed);
				return;
	    	}
	    }
	}

	public static function filter_field_attribute() {
		$temp = '';
		if(isset($_POST['field_constraint']) && !empty($_POST['field_constraint'])) {
			$temp .= 'required';
		}

		if(isset($_POST['field_minimum_value']) && !empty($_POST['field_minimum_value'])) {
			$temp .= '|min:' . $_POST['field_minimum_value'];
		}

		if(isset($_POST['field_maximum_value']) && !empty($_POST['field_maximum_value'])) {
			$temp .= '|max:' . $_POST['field_maximum_value'];
		}

		if($_POST['field_type'] == 'date') {
			$temp .= '|date';
		}

		return $temp;
	}

	public static function check_field_name() {
		$field = me_cf_check_field_name($_POST['field_name']);

		if($field) {
			$unique = false;
			$message = __('Field name must be unique.', 'enginethemes');
		} else {
			$unique = true;
			$message = '';
		}

		wp_send_json( array(
			'unique'	=> $unique,
			'message'	=> $message,
		) );
	}
}


ME_Custom_Field_Handle::init();