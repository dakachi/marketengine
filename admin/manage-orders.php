<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Manage listings in WP post screen
 */
function me_order_row_actions($actions, $post) {
    if ($post && 'me_order' == $post->post_type) {
        return array();
    }
    return $actions;
}
add_filter('post_row_actions', 'me_order_row_actions', 10, 2);

function me_me_order_columns($existing_columns) {
    if (empty($existing_columns) && !is_array($existing_columns)) {
        $existing_columns = array();
    }

    unset($existing_columns['comments'], $existing_columns['title'], $existing_columns['author'], $existing_columns['date'], $existing_columns['author']);

    $columns = array();

    $columns['order_id']      = 'ID';
    $columns['listing'] = 'Listing';
    $columns['total']   = 'Total';
    $columns['commission']  = 'Commission';
    $columns['date']        = 'Created';

    return array_merge($existing_columns, $columns);
}
add_filter('manage_me_order_posts_columns', 'me_me_order_columns');

function me_render_me_order_columns($column) {
    global $post, $wpdb;
    $order = me_get_order($post);

    switch ($column) {
    case 'order_id':
        $edit_post_link = edit_post_link( "#" . $post->ID );
        $edit_user_link = '<a href="'. get_edit_user_link( $post->post_author ) .'">'. get_the_author_meta( 'display_name', $post->post_author ) .'</a>';

        printf(__("%s by %s", "enginethemes"), $edit_post_link, $edit_user_link );
        break;
    
    case 'listing':
        $listing_items = $order->get_listing_items();
        foreach ($listing_items as $key => $listing) {
            $listing = get_post($listing['ID']);
            if($listing) {
                echo edit_post_link( esc_html( get_the_title($listing->ID) ),'','',$listing->ID );
            }else {
                echo $listing['title'];
            }
        }
        break;
    case 'total':
        $currency = get_post_meta( $post->ID, '_order_currency', true );
        echo me_price_html(get_post_meta($post->ID, '_order_total', true), $currency);
        break;
    }
}
add_action('manage_me_order_posts_custom_column',  'me_render_me_order_columns', 2);
