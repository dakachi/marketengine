<?php
/**
 * ME Admin Functions
 *
 * @author   EngineThemes
 * @category Function
 * @package  Admin/Functions
 * @since    1.0.1
 * @version  1.0.0
 */

/**
 * Filters admin notices
 *
 * Fires when admin site loaded.
 *
 * @category    Admin
 * @since       1.0.1
 */
function me_admin_notice_filter( $notices ) {

	$payment_setting = me_check_payment_setting();
	$menu_page = $_GET['page'];
	$link = me_menu_page_url('me-settings', 'payment-gateways');

	if( !$payment_setting && 'me-settings' === $menu_page) {
		$notices['payment_gateway_error'] = sprintf(__("Your site currently can't process payment yet, since your PayPal API hasn't been set up correctly.<br/>Please visit <a href='%s'>this page</a> to fix the issue."), $link );
	}

	return $notices;
}
add_filter('me_admin_notices', 'me_admin_notice_filter');


/**
 * Checks if payment gateway is correct
 *
 * @category    Admin
 * @since       1.0.1
 */
function me_check_payment_setting() {
	$paypal_email = me_option('paypal-receiver-email');
	$paypal_app_id = me_option('paypal-app-api');
	$paypal_api_username = me_option('paypal-api-username');
	$paypal_api_password = me_option('paypal-api-password');
	$paypal_api_signature = me_option('paypal-api-signature');

	return ( isset( $paypal_email ) && !empty( $paypal_email ) && is_email( $paypal_email )
			&& isset( $paypal_app_id ) && !empty( $paypal_app_id )
			&& isset( $paypal_api_username ) && !empty( $paypal_api_username )
			&& isset( $paypal_api_password ) && !empty( $paypal_api_password )
			&& isset( $paypal_api_signature ) && !empty( $paypal_api_signature ) );
}

/**
 * Get the url to access a particular menu page based on the slug it was registered with.
 *
 * If the slug hasn't been registered properly no url will be returned
 *
 * @since 1.0.1
 *
 * @global array $_parent_pages
 *
 * @param string $menu_slug The slug name to refer to this menu by (should be unique for this menu)
 * @param string $tab The tab name to refer to this menu (optional).
 * @param bool $echo Whether or not to echo the url - default is true
 * @return string the url
 */
function me_menu_page_url( $menu_slug = 'me-settings', $tab = '', $echo = false) {
	global $_parent_pages;

	if ( isset( $_parent_pages[$menu_slug] ) ) {
		$parent_slug = $_parent_pages[$menu_slug];
		if ( $parent_slug && ! isset( $_parent_pages[$parent_slug] ) ) {
			$url = admin_url( add_query_arg( 'page', $menu_slug, $parent_slug ) );
		} else {
			$url = admin_url( 'admin.php?page=' . $menu_slug );
		}

		if( !empty($tab) ) {
			$url = add_query_arg( 'tab', $tab, $url );
		}

	} else {
		$url = '';
	}

	$url = esc_url($url);

	if ( $echo )
		echo $url;

	return $url;
}

/**
 * List custom field type
 *
 * @since 	1.0.1
 */
function me_list_custom_field_type() {
	$field_types = array(
		array(
			'label'		=> __("Basic", "enginethemes"),
			'options'	=> array(
				'text'		=> 'Text',
				'textarea'	=> 'Textarea',
				'number'	=> 'Number',
				'date'		=> 'Date',
			),
		),
		array(
			'label'		=> __("Choose", "enginethemes"),
			'options'	=> array(
				'checkbox'				 => 'Checkbox',
				'radio'					 => 'Radio',
				'single-select' => 'Dropdown Single Select',
				'multi-select'	 => 'Dropdown Multi Select',
			),
		),
	);

	$field_types = apply_filters('filter_custom_field', $field_types);

	return $field_types;
}

/**
 * Loads custom field templates
 *
 * @since 	1.0.1
 * @version 1.0.0
 */
function marketengine_custom_field_template() {
    if(isset($_REQUEST['view']) && $_REQUEST['view'] == 'add') {
        me_get_template('admin/add-custom-field');
    } else {
        me_get_template('admin/custom-field');
    }
}

/**
 * Prepares content of custom field section
 *
 * @since 	1.0.1
 * @version 1.0.0
 */
function marketengine_add_actions() {
    if( is_admin() && isset($_REQUEST['section']) && $_REQUEST['section'] == 'custom-field') {
        add_action( 'wp_print_scripts', 'marketengine_dequeue_script', 100 );
        add_action('get_custom_field_template', 'marketengine_custom_field_template');
    }
}
add_action('wp_loaded', 'marketengine_add_actions');

/**
 * Removes ajax handle of option
 *
 * @since 	1.0.1
 * @version 1.0.0
 */
function marketengine_dequeue_script() {
   wp_dequeue_script( 'option-view' );
}
