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

		add_action('wp_ajax_me_cf_load_input_type', array(__CLASS__, 'load_field_input_type'));
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

	public static function load_field_input_type() {
	    $options = '';

	    switch($_POST['field_type']) {
	        case 'text':
	        case 'textarea':
	            $options .= '<div class="me-group-field">';
	            $options .= '<label class="me-title">'.__('Placeholder', 'enginethemes').' <small>'.__('(optional)', 'enginethemes').'</small></label>';
	            $options .= '<span class="me-field-control">';
	            $options .= '<input class="me-input-field" type="text" name="field_placeholder">';
	            $options .= '</span>';
	            $options .= '</div>';
	            break;

	        case 'number':
	            $options .= '<div class="me-group-field">';
	            $options .= '<label class="me-title">'.__('Placeholder', 'enginethemes').' <small>'.__('(optional)', 'enginethemes').'</small></label>';
	            $options .= '<span class="me-field-control">';
	            $options .= '<input class="me-input-field" type="text" name="field_placeholder">';
	            $options .= '</span>';
	            $options .= '</div>';
	            $options .= '<div class="me-group-field">';
	            $options .= '<label class="me-title">'.__('Minimum value', 'enginethemes').' <small>'.__('(optional)', 'enginethemes').'</small></label>';
	            $options .= '<span class="me-field-control">';
	            $options .= '<input class="me-input-field" type="number" name="field_minimum_value">';
	            $options .= '</span>';
	            $options .= '</div>';
	            $options .= '<div class="me-group-field">';
	            $options .= '<label class="me-title">'.__('Maximum value', 'enginethemes').' <small>'.__('(optional)','enginethemes').'</small></label>';
	            $options .= '<span class="me-field-control">';
	            $options .= '<input class="me-input-field" type="number" name="field_maximum_value">';
	            $options .= '</span>';
	            $options .= '</div>';
	            break;
	        case 'date':
	            break;

	        case 'checkbox':
	        case 'radio':
	            $options .= '<div class="me-group-field">';
	            $options .= '<label class="me-title">'.__('Option','enginethemes').'</label>';
	            $options .= '<span class="me-field-control">';
	            $options .= '<textarea class="me-textarea-field" name="option_values" placeholder="'.__('Enter each option on a new line', 'enginethemes').'"></textarea>';
	            $options .= '</span>';
	            $options .= '</div>';
	            break;

	        case 'single-select':
	        case 'multi-select':
	            $options .= '<div class="me-group-field">';
	            $options .= '<label class="me-title">'.__('Option none', 'enginethemes').'</label>';
	            $options .= '<span class="me-field-control">';
	            $options .= '<input class="me-input-field" type="text" name="option_none">';
	            $options .= '</span>';
	            $options .= '</div>';
	            $options .= '<div class="me-group-field">';
	            $options .= '<label class="me-title">'.__('Option','enginethemes').'</label>';
	            $options .= '<span class="me-field-control">';
	            $options .= '<textarea class="me-textarea-field" name="option_values" placeholder="'.__('Enter each option on a new line', 'enginethemes').'"></textarea>';
	            $options .= '</span>';
	            $options .= '</div>';
	            break;

	        default:
	            break;
	    }

	    wp_send_json(array(
	    	'options' => $options
	    ));
	}
}

ME_Custom_Field_Handle::init();