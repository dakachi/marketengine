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

    unset($existing_columns['comments'], $existing_columns['date'], $existing_columns['author']);

    $columns = array();

    $columns['type']             = 'Type';
    $columns['listing_category'] = 'Categories';
    $columns['price']            = 'Price';
    $columns['author']           = 'Author';
    $columns['date']             = 'Posted';

    return array_merge($existing_columns, $columns);
}
add_filter('manage_me_order_posts_columns', 'me_me_order_columns');

function me_render_me_order_columns($column) {
    global $post, $wpdb;

    switch ($column) {
    case 'type':
        $listing_type = get_post_meta($post->ID, '_me_listing_type', true);
        if (!empty($listing_type)) {
         	echo esc_html(me_get_listing_type_lable($listing_type));
        }
        break;
    
    case 'listing_category':
        $categoryarray = array();
        $categories    = get_the_terms($post->ID, 'listing_category');
        if ($categories) {
            foreach ($categories as $category) {
                $categoryarray[] = edit_term_link($category->name, '', '', $category, false);
            }
            echo implode(', ', $categoryarray);
        } else {
            echo '&ndash;';
        }
        break;
    
    case 'price':
        echo me_price_html(get_post_meta($post->ID, 'listing_price', true));
        break;
    }
}
add_action('manage_me_order_posts_custom_column',  'me_render_me_order_columns', 2);