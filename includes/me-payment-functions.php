<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get all available payment gateways from admin settings
 *
 * @since 1.0
 * @return array Array of payment gateways object
 */
function me_get_available_payment_gateways() {
	$available_gateways =  array(
		// 'cash' => new ME_Cash(),
		// 'ppsimple' => new ME_Paypal_Simple(),
		'ppadaptive' => ME_PPAdaptive_Request::instance()
	);
	return apply_filters('marketengine_available_payment_gateways', $available_gateways);
}

/** 
 * Check a gateway is available or not
 * @since 1.0
 * @return bool
 */
function me_is_available_payment_gateway($gateway) {
	$available_gateways = me_get_available_payment_gateways();
	return isset($available_gateways[$gateway]);
}

/**
 * Retrive site currency settings
 * @return Array
 * @since 1.0
 */
function get_marketengine_currency() {
	$sign = me_option('payment-currency-sign', '$');
    $code = me_option('payment-currency-code', 'USD');
    $is_align_right = me_option('currency-sign-postion') ? true : false;
    $label = me_option('payment-currency-lable', 'USD');
    return compact('sign', 'code', 'is_align_right', 'label');
}

add_filter('marketengine_currency_code', 'get_marketengine_currency');