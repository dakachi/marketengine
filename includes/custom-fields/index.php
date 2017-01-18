<?php
/**
 * Includes custom field functions files
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

require_once ME_PLUGIN_PATH . '/includes/custom-fields/me-cf-functions.php';
require_once ME_PLUGIN_PATH . '/includes/custom-fields/me-cf-template-functions.php';
require_once ME_PLUGIN_PATH . '/includes/custom-fields/class-me-admin-custom-field-form.php';
require_once ME_PLUGIN_PATH . '/includes/custom-fields/class-me-admin-custom-field.php';
require_once ME_PLUGIN_PATH . '/includes/custom-fields/class-me-handle-cf.php';
require_once ME_PLUGIN_PATH . '/includes/custom-fields/me-cf-taxonomy-function.php';


function me_setup_custom_field() {
	ME_Handle_CF::instance();
	ME_Custom_Field_Form::init();
	// ME_Custom_Field_Handle::init();
}
add_action('after_setup_theme', 'me_setup_custom_field');