<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function me_get_available_payment_gateways() {
	return array('cash', 'ppsimple', 'ppadaptive');
}

function me_is_available_payment_gateway($gateway) {
	$available_gateways = me_get_available_payment_gateways();
	return in_array($gateway, $available_gateways);
}