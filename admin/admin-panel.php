<?php
function marketengine_option_view () {
	include 'option-view.php';
}

/** 
 * 
 */
function marketengine_option_menu() {
    add_menu_page(
        __("MarketEngine Dashboard", "enginethemes"),
        __("EngineThemes", "enginethemes"),
        'manage_options',
        'marketengine',
        'marketengine_option_view',
        '',
        null
    );
}
add_action('admin_menu', 'marketengine_option_menu');

function marketengine_load_admin_option_script_css() {
	wp_register_style( 'marketengine-font-icon',  ME_PLUGIN_URL . '/assets/admin/jquery.mCustomScrollbar.min.css', array(), '1.0');
	wp_enqueue_style( 'me-option-css', ME_PLUGIN_URL . '/assets/admin/marketengine-admin.css');

	wp_enqueue_script( 'jquery-scrollbar', ME_PLUGIN_URL . '/assets/admin/jquery.mCustomScrollbar.min.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'marketengine-option', ME_PLUGIN_URL . '/assets/admin/script-admin.js', array('jquery', 'jquery-scrollbar'), '1.0', true );

	
}
add_action('admin_enqueue_scripts', 'marketengine_load_admin_option_script_css');