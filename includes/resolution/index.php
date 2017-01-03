<?php
/**
 * Includes custom field functions files
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

require_once ME_PLUGIN_PATH . '/includes/resolution/me-rc-functions.php';
require_once ME_PLUGIN_PATH . '/includes/resolution/me-rc-template-functions.php';

require_once ME_PLUGIN_PATH . '/includes/resolution/class-me-rc-form.php';
require_once ME_PLUGIN_PATH . '/includes/resolution/class-me-rc-handle.php';
require_once ME_PLUGIN_PATH . '/includes/resolution/class-me-rc-query.php';

function me_setup_resolution_center() {
	ME_RC_Form::init();
	ME_RC_Query::instance();
}
add_action('after_setup_theme', 'me_setup_resolution_center');