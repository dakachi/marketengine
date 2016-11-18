<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Manage listings in WP post screen
 */

/**
 * Remove post row action to prevent admin edit listing
 * @category Admin/Manage
 * @since 1.0
 */
function post_row_actions($actions, $post)
{
    if ($post && 'listing' == $post->post_type) {
        return array();
    }
    return $actions;
}
add_filter('post_row_actions', 'post_row_actions', 10, 2);

/**
 * Add and modify listing post column
 * @category Admin/Manage
 * @since 1.0
 */
function me_listing_columns($existing_columns)
{
    if (empty($existing_columns) && !is_array($existing_columns)) {
        $existing_columns = array();
    }

    unset($existing_columns['comments'], $existing_columns['date'], $existing_columns['title']);

    $columns = array();

    $columns['post_title']       = 'Title';
    $columns['type']             = 'Type';
    $columns['listing_category'] = 'Categories';
    $columns['price']            = 'Price';
    $columns['author']   = 'Author';
    $columns['date']             = 'Posted';

    return array_merge($existing_columns, $columns);
}
add_filter('manage_listing_posts_columns', 'me_listing_columns');

/**
 * Render listing column value
 * @category Admin/Manage
 * @since 1.0
 */
function me_render_listing_columns($column)
{
    global $post, $wpdb;

    switch ($column) {
        case 'post_title':
            echo '<a href="' . get_permalink($post->ID) . '" target="_blank" >' . esc_html(get_the_title($post->ID)) . '</a>';
            break;

        case 'author_profile':
            printf(
                '<a target="_blank" href="%1$s" title="%2$s" rel="author">%3$s</a>',
                esc_url(get_author_posts_url($post->post_author, get_the_author_meta( 'display_name', '$post->post_author' ))),
                esc_attr(sprintf(__('Posts by %s'), get_the_author())),
                get_the_author()
            );
            break;

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
            $price = get_post_meta($post->ID, 'listing_price', true);
            if ($price) {
                echo me_price_html($price);
            }
            break;
    }
}
add_action('manage_listing_posts_custom_column', 'me_render_listing_columns', 2);

/**
 * Add listing metabox, remove authordiv
 * @category Admin/Manage
 * @since 1.0
 */
function me_listing_meta_box()
{
    remove_meta_box('authordiv', 'listing', 'normal');
}
add_action('add_meta_boxes', 'me_listing_meta_box');
