<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function me_insert_order($order_data) {
    $order_data['post_type'] = 'me_order';
    return wp_insert_post($order_data);
}

function me_add_order_item($order_id, $item_name, $item_type = 'listing') {
    global $wpdb;

    $order_id = absint($order_id);

    $wpdb->insert(
        $wpdb->prefix . 'marketengine_order_items',
        array(
            'order_item_name' => $item_name,
            'order_item_type' => $item_type,
            'order_id' => $order_id,
        ),
        array(
            '%d', // value1
            '%s', // value2
            '%s',
            '%d',
        )
    );

    $item_id = absint($wpdb->insert_id);

    do_action('marketengine_new_order_item', $item_id, $item_name, $order_id);

    return $item_id;
}

function me_update_order_item($item_id, $args) {
    global $wpdb;

    $item_id = absint($item_id);
    $update = $wpdb->update(
        $wpdb->prefix . 'marketengine_order_items',
        $args,
        array('order_item_id' => $item_id)
    );

    if (false === $update) {
        return false;
    }

    do_action('marketengine_update_order_item', $item_id, $args);

    return true;
}

function me_delete_order_item($item_id) {
    global $wpdb;

    $item_id = absint($item_id);

    do_action('marketengine_before_delete_order_item', $item_id);

    $update = $wpdb->delete('table', array('order_item_id' => $item_id));
    if (false === $update) {
        return false;
    }

    do_action('marketengine_after_delete_order_item', $item_id);

    return true;
}

function me_get_order_item_meta($order_item_id, $key = '', $single = false) {
	return get_metadata('post', $order_item_id, $key, $single);
}
function me_add_order_item_meta($order_item_id, $meta_key, $meta_value, $unique) {
	return add_metadata('order_item', $order_item_id, $meta_key, $meta_value, $unique);
}

function me_update_order_item_meta($order_item_id, $meta_key, $meta_value, $prev_value = '' ) {
	return update_metadata('order_item', $order_item_id, $meta_key, $meta_value, $prev_value);
}

function me_delete_order_item_meta($order_item_id, $meta_key, $meta_value = '') {
	return delete_metadata('order_item', $order_item_id, $meta_key, $meta_value);
}