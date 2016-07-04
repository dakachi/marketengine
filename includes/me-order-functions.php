<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Insert an order
 *
 * @see wp_insert_post
 * @param array $order_data
 *
 * @since 1.0
 *
 * @return int|WP_Error The post ID on success. The value 0 or WP_Error on failure.
 */
function me_insert_order($order_data) {
    $order_data['post_type'] = 'me_order';
    return wp_insert_post($order_data);
}

/**
 * Update a order with new order data.
 *
 * @see wp_update_post
 * @param array $order
 *
 * @since 1.0
 *
 * @return int|WP_Error The post ID on success. The value 0 or WP_Error on failure.
 */
function me_update_order($order) {
    $order_data['post_type'] = 'me_order';
    return wp_update_post($order);
}

function me_dispute_order() {

}

function me_complete_order() {

}

/**
 * Marketengine Add order item
 *
 * Store the order item details to an order
 *
 * @param int $order_id
 * @param string $item_name
 * @param string $item_type
 *
 * @since 1.0
 *
 * @return int
 */
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

/**
 * Marketengine Update order item
 *
 * Update order item details base on order_item_id
 *
 * @param int $item_id
 * @param array $args
 *
 * @since 1.0
 *
 * @return bool
 */
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
/**
 * Marketengine Delete order item
 *
 * @param int $item_id
 *
 * @since 1.0
 *
 * @return bool
 */
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

/**
 * Retrieve post meta field for a order item.
 *
 * @since 1.0
 *
 * @param int    $order_item_id    Post ID.
 * @param string $key     Optional. The meta key to retrieve. By default, returns data for all keys. Default empty.
 * @param bool   $single  Optional. Whether to return a single value. Default false.
 *                           Default false.
 * @return mixed Will be an array if $single is false. Will be value of meta data field if $single is true.
 */
function me_get_order_item_meta($order_item_id, $key = '', $single = false) {
    return get_metadata('post', $order_item_id, $key, $single);
}

/**
 * Add meta data field to a order item
 *
 * @since 1.0
 *
 * @param int    $order_item_id    Post ID.
 * @param string $meta_key   Metadata name.
 * @param mixed  $meta_value Metadata value. Must be serializable if non-scalar.
 * @param bool   $unique     Optional. Whether the same key should not be added.
 *                           Default false.
 * @return int|false Meta ID on success, false on failure.
 */
function me_add_order_item_meta($order_item_id, $meta_key, $meta_value, $unique) {
    return add_metadata('order_item', $order_item_id, $meta_key, $meta_value, $unique);
}

/**
 *  Update post meta field based on order_item_id.
 *
 * @since 1.0
 *
 * @param int    $order_item_id    Post ID.
 * @param string $meta_key   Metadata name.
 * @param mixed  $meta_value Metadata value. Must be serializable if non-scalar.
 * @param mixed  $prev_value Optional. Previous value to check before removing.
 *                           Default empty.
 * @return int|false Meta ID if the key didn't exist, true on successful update, false on failure.
 */

function me_update_order_item_meta($order_item_id, $meta_key, $meta_value, $prev_value = '') {
    return update_metadata('order_item', $order_item_id, $meta_key, $meta_value, $prev_value);
}

/**
 * Remove metadata matching criteria from a order item.
 *
 * @since 1.0
 *
 * @param int    $order_item_id    Post ID.
 * @param string $meta_key   Metadata name.
 * @param mixed  $meta_value Metadata value. Must be serializable if non-scalar.
 *
 * @return bool True on success, false on failure.
 */
function me_delete_order_item_meta($order_item_id, $meta_key, $meta_value = '') {
    return delete_metadata('order_item', $order_item_id, $meta_key, $meta_value);
}