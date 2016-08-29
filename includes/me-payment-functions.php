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
		'ppsimple' => new ME_Paypal_Simple(),
		'ppadaptive' => ME_PPAdaptive::instance()
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

function get_marketengine_currency() {
	return 'USD';
}

function me_setup_payment($order) {
	
}

function me_process_payment($order) {
	
}