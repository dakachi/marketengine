<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

function me_order_meta_box()
{
    add_meta_box('order_meta', __('Order Payment Info'), 'me_order_payment_details', 'me_order', 'normal', 'high');
}
add_action('add_meta_boxes', 'me_order_meta_box');


function me_order_payment_details() {
	global $post;
	$post_id = $post->ID;
	$paykey =  get_post_meta( $post_id, '_me_ppadaptive_paykey', true );
	$response = ME_PPAdaptive::instance()->payment_details($paykey);
	echo "<pre>";
	print_r($response);
	echo "</pre>";
}