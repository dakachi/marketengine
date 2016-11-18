<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Manage orders in WP post screen
 */

/**
 * Remove edit post row action
 * @since 1.0
 */
function me_order_row_actions($actions, $post)
{
    if ($post && 'me_order' == $post->post_type) {
        return false;
    }
    return $actions;
}
add_filter('post_row_actions', 'me_order_row_actions', 10, 2);

/**
 * Hook to action manage_me_order_posts_columns
 * Add order columns: ID, Listing Items, Tota, Commission, Date
 *
 * @param array $existing_columns WP default post column
 * @since 1.0
 */
function me_me_order_columns($existing_columns)
{
    if (empty($existing_columns) && !is_array($existing_columns)) {
        $existing_columns = array();
    }

    unset($existing_columns['comments'], $existing_columns['title'], $existing_columns['date'], $existing_columns['author']);

    $columns = array();

    $columns['status']   = 'Status';
    $columns['order_id']   = 'ID';
    $columns['listing']    = 'Listing';
    $columns['total']      = 'Total';
    $columns['commission'] = 'Commission';
    $columns['date']       = 'Date';

    return array_merge($existing_columns, $columns);
}
add_filter('manage_me_order_posts_columns', 'me_me_order_columns');

/**
 * Hook to manage_me_order_posts_custom_column render order column data
 *
 * @param string $column
 * @since 1.0
 */
function me_render_me_order_columns($column)
{
    global $post, $wpdb;
    $order = me_get_order($post);

    switch ($column) {
        case 'status':
            echo me_get_order_status_label($post->post_status);
            break;

        case 'order_id':
            $edit_post_link = edit_post_link("#" . $post->ID);
            $edit_user_link = '<a href="' . get_edit_user_link($post->post_author) . '">' . get_the_author_meta('display_name', $post->post_author) . '</a>';

            printf(__("%s by %s", "enginethemes"), $edit_post_link, $edit_user_link);
            break;
        case 'listing':
            $listing_items = $order->get_listing_items();
            foreach ($listing_items as $key => $listing) {
                $listing = get_post($listing['ID']);
                if ($listing) {
                    echo edit_post_link(esc_html(get_the_title($listing->ID)), '', '', $listing->ID);
                } else {
                    echo $listing['title'];
                }
            }
            break;
        case 'commission':
            $currency         = get_post_meta($post->ID, '_order_currency', true);
            $commission_items = me_get_order_items($post->ID, 'commission_item');
            if (!empty($commission_items)) {
                $item_id = $commission_items[0]->order_item_id;
                echo me_price_html(me_get_order_item_meta($item_id, '_amount', true), $currency);
            }
            break;

        case 'total':
            $currency = get_post_meta($post->ID, '_order_currency', true);
            echo me_price_html(get_post_meta($post->ID, '_order_total', true), $currency);
            break;
    }
}
add_action('manage_me_order_posts_custom_column', 'me_render_me_order_columns', 2);

function me_order_payment_details() {
    me_get_template('admin/order-metabox');
}

function me_order_meta_box()
{
    add_meta_box('order_meta', __('Order Payment Info'), 'me_order_payment_details', 'me_order', 'normal', 'high');
    remove_meta_box('submitdiv', 'me_order', 'side');
}
add_action('add_meta_boxes', 'me_order_meta_box');

