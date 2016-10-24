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
    $order_data['post_type']  = 'me_order';
    $order_data['post_title'] = 'Order-' . date(get_option('links_updated_date_format'), current_time('timestamp'));

    $order_data['post_status'] = apply_filters('marketengine_create_order_status', 'me-pending');

    if (!empty($order_data['customer_note'])) {
        $order_data['post_excerpt'] = $order_data['customer_note'];
    }
    /**
     * Filter insert order data
     * @param array $order_data
     * @since 1.0
     */
    $order_data = apply_filters('marketengine_insert_order_data', $order_data);
    $order_id   = wp_insert_post($order_data, false);
    if ($order_id) {
        /**
         * filter to get order currency code
         * @param string
         * @since 1.0
         */
        $currency_code = apply_filters('marketengine_currency_code', 'USD');
        update_post_meta($order_id, '_order_currency_code', $currency_code);
        // hash password
        update_post_meta($order_id, '_me_order_key', 'marketengine-' . wp_hash_password(time()));
        // store client ip, agent
        update_post_meta($order_id, '_me_customer_ip', me_get_client_ip());
        update_post_meta($order_id, '_me_customer_agent', me_get_client_agent());
        /**
         * marketengine_after_create_order
         * add action after create order successful
         *
         * @param int $order_id
         * @param array $order_data
         *
         * @since 1.0
         */
        do_action('marketengine_after_create_order', $order_id, $order_data);
    }
    return $order_id;
}

/**
 * Update a order with new order data.
 *
 * @see wp_update_post
 * @param array $order_data
 *
 * @since 1.0
 *
 * @return int|WP_Error The post ID on success. The value 0 or WP_Error on failure.
 */
function me_update_order($order_data) {
    $order_data              = apply_filters('marketengine_update_order_data', $order_data);
    // First, get all of the original fields.
    $post = get_post($order_data['ID'], ARRAY_A);

    if ( is_null( $post ) || $post->post_type  !== 'me_order' ) {
        return new WP_Error( 'invalid_order', __( 'Invalid order ID.', 'enginethemes' ) );
    }

    // Escape data pulled from DB.
    $post = wp_slash($post);
    $order_data = array_merge($post, $order_data);

    return me_insert_order($order_data);
}


/**
 * Order completed, fund has been sent to seller
 * @param int $order_id The order id
 */
function me_complete_order($order_id) {

    $post_status = get_post_status( $order_id );

    if($post_status == 'me-complete') return ;

    $order_id = wp_update_post(array(
        'ID'          => $order_id,
        'post_status' => 'me-complete',
    ));

    do_action('marketengine_complete_order', $order_id);
}

/**
 * Order in-complete, order was not yet eligible to transfer money to the account Seller.
 * @param int $order_id The order id
 */
function me_active_order($order_id) {

    $post_status = get_post_status( $order_id );

    if($post_status == 'publish') return ;

    wp_update_post(array(
        'ID'          => $order_id,
        'post_status' => 'publish',
    ));
    do_action('marketengine_active_order', $order_id);
}

function me_dispute_order($order_id) {}

function me_get_order() {

}

function me_get_order_ids( $value, $type ) {
    global $wpdb;
    $operator = '=';
    if( $type == 'listing_item') {
        $operator = 'LIKE';
        $value = "%{$value}%";
    }
    $query = "SELECT order_items.order_id
            FROM $wpdb->marketengine_order_items as order_items
            WHERE order_items.order_item_type = '{$type}' AND
                order_items.order_item_name {$operator} '{$value}'";

    $results = $wpdb->get_col($query);
    return $results;
}

/**
 *  Returns order query args
 *  @param: $query
 *  @return: $args - query args
 */
function me_filter_order_query( $query, $type = '') {
    $args['post__in'] = array();

    if( isset($query['order_status']) && $query['order_status'] !== '' && $query['order_status'] !== 'any' ){
        $args['post_status'] = $query['order_status'];
    }

    if( $type == 'order' && (!isset($query['order_status']) || $query['order_status'] == '' || $query['order_status'] == 'any') ) {
        $statuses = me_get_order_status_list();
        unset($statuses['me-pending']);
        unset($statuses['publish']);
        $query['order_status'] = array_keys($statuses);
        $args['post_status'] = $query['order_status'];
    }

    if( isset($query['from_date']) || isset($query['to_date']) ){
        $after = isset($query['from_date']) ? $query['from_date'] : '';
        $before = isset($query['to_date']) ? $query['to_date'] . '23:59:59' : '';
        $args['date_query'] = array(
            array(
                'after'     => $after,
                'before'    => $before,
            ),
        );
    }

    if( $type == 'order' ) {
        $user_data = get_userdata( get_current_user_id() );
        $order_ids = me_get_order_ids( $user_data->user_login, 'receiver_item' );
        if( empty($order_ids) ) {
            $args['post__in'] = array(-1);
            return $args;
        } else {
            $args['post__in'] = $order_ids;
        }
    } else {
        $args['author'] = get_current_user_id();
    }

    $keyword_result = array();
    if( isset($query['keyword']) && !empty($query['keyword']) ) {
        $id_by_listing = me_get_order_ids( $query['keyword'], 'listing_item' );

        $id_by_keyword = array();
        if( is_numeric($query['keyword']) ) {
            $id_by_keyword = array( $query['keyword'] );
        }
        $keyword_result = array_merge($id_by_keyword, $id_by_listing);

        if( $type == 'order') {
            $args['post__in'] = array_intersect($keyword_result, $args['post__in']);
        } else {
            $args['post__in'] = $keyword_result;
        }

        if( empty($args['post__in']) ) {
            $args['post__in'] = array(-1);
        }
    }

    return $args;
}
add_filter( 'me_filter_order', 'me_filter_order_query', 1, 2 );

/**
 * MarketEngine Get Order Status Listing
 *
 * Retrieve marketengine order status list
 *
 * @since 1.0
 * @return array
 */
function me_get_order_status_list() {
    $order_status = array(
        'me-pending'  => __("Pending", "enginethemes"), // mainly intended for technical case, when an error occurs payment, or payment by bank transfer confirmation to admin
        'publish'     => __("Active", "enginethemes"), // Status of payment order was not yet eligible to transfer money to the account Seller.
        'me-complete' => __("Finished", "enginethemes"), // State order has been completed and is paid to the target account Seller & Admin.
        'me-disputed' => __("Disputed", "enginethemes"), // Order status are taken into account when processing complaints occur
        'me-closed'   => __("Closed", "enginethemes"), // The end of the first order, while moving through this state can not be anymore Dispute
        'me-resolved' => __("Resolved", "enginethemes"), // Similar "closed", the end point of the first order, after the complaint was handled.
    );
    return apply_filters('marketengine_get_order_status_list', $order_status);
}

/**
 * Retrieve order items
 *
 * @param int $order_id The order id
 * @param string $type The item type
 *
 * @since 1.0
 *
 * @return array Array of order item object
 */
function me_get_order_items($order_id, $type = '') {
    global $wpdb;
    if ($type) {
        $query = "SELECT *
                FROM $wpdb->marketengine_order_items as order_items
                WHERE order_items.order_id = '{$order_id}'
                    AND order_items.order_item_type = '{$type}'";
    } else {
        $query = "SELECT *
                FROM $wpdb->marketengine_order_items as order_items
                WHERE order_items.order_id = '{$order_id}'";
    }

    $results = $wpdb->get_results($query);
    return $results;
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
function me_add_order_item($order_id, $item_name, $item_type = 'listing_item') {
    global $wpdb;

    $order_id = absint($order_id);

    $wpdb->insert(
        $wpdb->prefix . 'marketengine_order_items',
        array(
            'order_item_name' => $item_name,
            'order_item_type' => $item_type,
            'order_id'        => $order_id,
        ),
        array(
            // '%d', // value1
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
    $update  = $wpdb->update(
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

    $update = $wpdb->delete($wpdb->prefix . 'marketengine_order_items', array('order_item_id' => $item_id));
    $update = $wpdb->delete($wpdb->prefix . 'marketengine_order_itemmeta', array('marketengine_order_item_id' => $item_id));

    if (false === $update) {
        return false;
    }

    do_action('marketengine_after_delete_order_item', $item_id);

    return true;
}

/**
 * Retrieve order item meta field for a order item.
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
    return get_metadata('marketengine_order_item', $order_item_id, $key, $single);
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
function me_add_order_item_meta($order_item_id, $meta_key, $meta_value, $unique = true) {
    return add_metadata('marketengine_order_item', $order_item_id, $meta_key, $meta_value, $unique);
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
    return update_metadata('marketengine_order_item', $order_item_id, $meta_key, $meta_value, $prev_value);
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
    return delete_metadata('marketengine_order_item', $order_item_id, $meta_key, $meta_value);
}

/**
 * Retrieve current user transactions
 */
function me_my_transactions($args) {

}

/**
 * Retrieve current user orders
 */
function me_my_orders() {

}