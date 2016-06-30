<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function me_insert_order($order_data) {
	$order_data['post_type'] = 'me_order';
	return wp_insert_post($order_data);
}

function me_add_order_item() {

}

function me_update_order_item() {

}

function me_remove_order_item() {

}

function me_add_order_item_meta() {

}

function me_update_order_item_meta() {

}

function me_remove_order_item_meta() {

}