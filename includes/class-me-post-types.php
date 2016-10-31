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
    /**
     * The single instance of the class.
     *
     * @var ME_Listing
     * @since 1.0
     */
    protected static $_instance = null;

    /**
     * Main ME_Listing Instance.
     *
     * Ensures only one instance of ME_Listing is loaded or can be loaded.
     *
     * @since 1.0
     * @return ME_Listing - Main instance.
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    /**
     * Register default taxonomies
     */
    public static function register_taxonomies() {
        $labels = array(
            'name'                  => _x('Category', 'Taxonomy plural name', "enginethemes"),
            'singular_name'         => _x('Listing category', 'Taxonomy singular name', "enginethemes"),
            'search_items'          => __('Search Category', "enginethemes"),
            'popular_items'         => __('Popular Category', "enginethemes"),
            'all_items'             => __('All Category', "enginethemes"),
            'parent_item'           => __('Parent listing category', "enginethemes"),
            'parent_item_colon'     => __('Parent listing category', "enginethemes"),
            'edit_item'             => __('Edit listing category', "enginethemes"),
            'update_item'           => __('Update listing category', "enginethemes"),
            'add_new_item'          => __('Add New listing category', "enginethemes"),
            'new_item_name'         => __('New listing category Name', "enginethemes"),
            'add_or_remove_items'   => __('Add or remove Category', "enginethemes"),
            'choose_from_most_used' => __('Choose from most used enginetheme ', "enginethemes"),
            'menu_name'             => __('Category', "enginethemes"),
        );
        //TODO: setup listing category permarlink
        $permalinks = get_option('me_permalinks');
        $args       = array(
            'labels'            => $labels,
            'public'            => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => false,
            'hierarchical'      => true,
            'show_tagcloud'     => true,
            'show_ui'           => true,
            'query_var'         => true,
            'rewrite'           => array(
                'slug'         => 'listing_category',
                'hierarchical' => true,
            ),
            'capabilities'      => array(
                'manage_terms',
                'edit_terms',
                'delete_terms',
                'assign_terms',
            ),
        );
        register_taxonomy('listing_category', array(
            'listing',
        ), $args);

        $labels = array(
            'name'                  => _x('Listing Tag', 'Taxonomy plural name', "enginethemes"),
            'singular_name'         => _x('Listing Tags', 'Taxonomy singular name', "enginethemes"),
            'search_items'          => __('Search Tags', "enginethemes"),
            'popular_items'         => __('Popular Tags', "enginethemes"),
            'all_items'             => __('All listing tags', "enginethemes"),
            'parent_item'           => __('Parent listing tags', "enginethemes"),
            'parent_item_colon'     => __('Parent listing tags', "enginethemes"),
            'edit_item'             => __('Edit listing tags', "enginethemes"),
            'update_item'           => __('Update listing tag', "enginethemes"),
            'add_new_item'          => __('Add New listing tag', "enginethemes"),
            'new_item_name'         => __('New listing tag Name', "enginethemes"),
            'add_or_remove_items'   => __('Tags (Add or remove tag)', "enginethemes"),
            'choose_from_most_used' => __('Choose from most used enginetheme ', "enginethemes"),
            'menu_name'             => __('Listing Tag', "enginethemes"),
        );
        //TODO: setup listing category permarlink
        $permalinks = get_option('me_permalinks');
        $args       = array(
            'labels'            => $labels,
            'public'            => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => false,
            'hierarchical'      => false,
            'show_tagcloud'     => true,
            'show_ui'           => true,
            'query_var'         => true,
            'rewrite'           => array(
                'slug' => 'listing_tag',
            ),
            'capabilities'      => array(
                'manage_terms',
                'edit_terms',
                'delete_terms',
                'assign_terms',
            ),
        );
        register_taxonomy('listing_tag', array(
            'listing',
        ), $args);

    }
    /**
     * Register post type listing
     */
    public static function register_post_type() {
        $permalinks = get_option('me_permalinks', 'listing');
        register_post_type('listing', array(
            'labels'             => array(
                'name'               => __('Listing', "enginethemes"),
                'singular_name'      => __('Listing', "enginethemes"),
                'add_new'            => __('Add New', "enginethemes"),
                'add_new_item'       => __('Add New Listing', "enginethemes"),
                'edit_item'          => __('Edit Listing', "enginethemes"),
                'new_item'           => __('New Listing', "enginethemes"),
                'all_items'          => __('All Listings', "enginethemes"),
                'view_item'          => __('View Listing', "enginethemes"),
                'search_items'       => __('Search Listings', "enginethemes"),
                'not_found'          => __('No Listing found', "enginethemes"),
                'not_found_in_trash' => __('No Listings found in Trash', "enginethemes"),
                'parent_item_colon'  => '',
                'menu_name'          => __('Listings', "enginethemes"),
            ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => $permalinks ? array('slug' => $permalinks, 'with_front' => false, 'feed' => true) : false,
            'capability_type'    => 'post',
            'has_archive'        => 'listings',
            'hierarchical'       => false,
            'menu_position'      => 25,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields'),
        ));

        register_post_status('me-archived', array(
            'label'                     => _x('Archived', 'listing'),
            'public'                    => false,
            'exclude_from_search'       => false,
            'private'                   => true,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop('Archived <span class="count">(%s)</span>', 'Archived <span class="count">(%s)</span>'),
        ));
        // register_post_status('me-paused', array(
        //     'label'                     => _x('Paused', 'listing'),
        //     'public'                    => false,
        //     'exclude_from_search'       => false,
        //     'private'                   => true,
        //     'show_in_admin_all_list'    => true,
        //     'show_in_admin_status_list' => true,
        //     'label_count'               => _n_noop('Paused <span class="count">(%s)</span>', 'Paused <span class="count">(%s)</span>'),
        // ));

        // TODO: tam thoi de day
        register_post_type('me_order', array(
            'labels'             => array(
                'name'               => __('Order', "enginethemes"),
                'singular_name'      => __('Order', "enginethemes"),
                'add_new'            => __('Add New', "enginethemes"),
                'add_new_item'       => __('Add New Order', "enginethemes"),
                'edit_item'          => __('Edit Order', "enginethemes"),
                'new_item'           => __('New Order', "enginethemes"),
                'all_items'          => __('All Orders', "enginethemes"),
                'view_item'          => __('View Order', "enginethemes"),
                'search_items'       => __('Search Order', "enginethemes"),
                'not_found'          => __('No Orders found', "enginethemes"),
                'not_found_in_trash' => __('No Orders found in Trash', "enginethemes"),
                'parent_item_colon'  => '',
                'menu_name'          => __('Order', "enginethemes"),
            ),
            'public'             => false,
            'publicly_queryable' => true,
            'rewrite'            => array(
                'slug' => me_get_endpoint_name('order-id') . '/%post_id%',
            ),
            'has_archive'        => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'capability_type'    => 'post',
            'hierarchical'       => false,
            'menu_position'      => 25,
            'supports'           => array('title', 'editor', 'author', 'excerpt', 'custom-fields'),
        ));

        register_post_status('me-pending', array(
            'label'                     => _x('Pending', 'me-order'),
            'public'                    => false,
            'exclude_from_search'       => false,
            'private'                   => true,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop('Pending <span class="count">(%s)</span>', 'Pending <span class="count">(%s)</span>'),
        ));

        register_post_status('me-active', array(
            'label'                     => _x('Finished', 'me-order'),
            'public'                    => false,
            'exclude_from_search'       => false,
            'private'                   => true,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop('Active <span class="count">(%s)</span>', 'Active <span class="count">(%s)</span>'),
        ));

        register_post_status('me-complete', array(
            'label'                     => _x('Completed', 'me-order'),
            'public'                    => true,
            'exclude_from_search'       => false,
            'private'                   => true,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop('Completed <span class="count">(%s)</span>', 'Completed <span class="count">(%s)</span>'),
        ));

        register_post_status('me-disputed', array(
            'label'                     => _x('Disputed', 'me-order'),
            'public'                    => true,
            'exclude_from_search'       => false,
            'private'                   => true,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop('Completed <span class="count">(%s)</span>', 'Disputed <span class="count">(%s)</span>'),
        ));

        register_post_status('me-closed', array(
            'label'                     => _x('Closed', 'me-order'),
            'public'                    => true,
            'exclude_from_search'       => false,
            'private'                   => true,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop('Completed <span class="count">(%s)</span>', 'Closed <span class="count">(%s)</span>'),
        ));

        register_post_status('me-resolved', array(
            'label'                     => _x('Resolved', 'me-order'),
            'public'                    => true,
            'exclude_from_search'       => false,
            'private'                   => true,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop('Completed <span class="count">(%s)</span>', 'Resolved <span class="count">(%s)</span>'),
        ));
    }
}