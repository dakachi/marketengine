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

	if( !$payment_setting && 'me-settings' === $menu_page) {
		$notices['payment_gateway_error'] = __("Your site currently can't process payment yet, since your PayPal API hasn't been set up correctly. Please visit this page to fix the issue.");
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