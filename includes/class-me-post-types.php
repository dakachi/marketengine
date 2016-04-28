<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Post types
 *
 * Register post types & taxonomies
 *
 * @class       ME_Post_Types
 * @version     1.0
 * @package     MarketEngine/Includes
 * @author      Dakachi
 * @category    Class
 */
class ME_Post_Types {

    public static function init() {

    }

    public static function register_taxonomies() {

    }

    public static function register_post_types() {
        $labels = array(
            'name'               => __('Listing', ET_DOMAIN),
            'singular_name'      => __('Listing', ET_DOMAIN),
            'add_new'            => __('Add New', ET_DOMAIN),
            'add_new_item'       => __('Add New Listing', ET_DOMAIN),
            'edit_item'          => __('Edit Listing', ET_DOMAIN),
            'new_item'           => __('New Listing', ET_DOMAIN),
            'all_items'          => __('All Listings', ET_DOMAIN),
            'view_item'          => __('View Listing', ET_DOMAIN),
            'search_items'       => __('Search Listings', ET_DOMAIN),
            'not_found'          => __('No Listings found', ET_DOMAIN),
            'not_found_in_trash' => __('No Listings found in Trash', ET_DOMAIN),
            'parent_item_colon'  => '',
            'menu_name'          => __('Listings', ET_DOMAIN),
        );

        register_post_type('listing', array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array(
                'slug' => 'listing',
            ),
            'capability_type'    => 'post',
            'has_archive'        => 'listings',
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array(
                'title',
                'editor',
                'author',
                'thumbnail',
                'excerpt',
                'comments',
                'custom-fields',
            ),
        ));
    }

    public static function register_post_statuses() {

    }
}
