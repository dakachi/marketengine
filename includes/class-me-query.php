<?php

/**
 *
 */
function me_pre_get_posts($query){
    // Only affect the main query
    if( !$query->is_main_query() ){
        return;
    }
    if( $GLOBALS['wp_rewrite']->use_verbose_page_rules && isset( $query->queried_object->ID ) && $query->queried_object->ID === me_get_page_id( 'listings' ) ){
        $query->set( 'post_type', 'listing' );
        $query->set( 'page', '' );
        $query->set( 'pagename', '' );

        // Fix conditional Functions
        $query->is_archive           = true;
        $query->is_post_type_archive = true;
        $query->is_singular          = false;
        $query->is_page              = false;
    }

    // Fix for endpoints on the homepage
    if ( $query->is_home() && 'page' === get_option( 'show_on_front' ) && absint( get_option( 'page_on_front' ) ) !== absint( $query->get( 'page_id' ) ) ) {
        $_query = wp_parse_args( $query->query );
        if ( ! empty( $_query ) ) {
            $query->is_page     = true;
            $query->is_home     = false;
            $query->is_singular = true;
            $query->set( 'page_id', (int) get_option( 'page_on_front' ) );
            add_filter( 'redirect_canonical', '__return_false' );
        }
    }

    // When orderby is set, WordPress shows posts. Get around that here.
    if ( $query->is_home() && 'page' === get_option( 'show_on_front' ) && absint( get_option( 'page_on_front' ) ) === me_get_page_id( 'listings' ) ) {
        $_query = wp_parse_args( $query->query );
        if ( empty( $_query ) || ! array_diff( array_keys( $_query ), array( 'preview', 'page', 'paged', 'cpage', 'orderby' ) ) ) {
            $query->is_page = true;
            $query->is_home = false;
            $query->set( 'page_id', (int) get_option( 'page_on_front' ) );
            $query->set( 'post_type', 'listing' );
        }
    }

    // Special check for shops with the listing archive on front
    if ( $query->is_page() && 'page' === get_option( 'show_on_front' ) && absint( $query->get( 'page_id' ) ) === me_get_page_id( 'listings' ) ) {

        // This is a front-page shop
        $query->set( 'post_type', 'listing' );
        $query->set( 'page_id', '' );

        if ( isset( $query->query['paged'] ) ) {
            $query->set( 'paged', $query->query['paged'] );
        }

        // Get the actual WP page to avoid errors and let us use is_front_page()
        // This is hacky but works. Awaiting https://core.trac.wordpress.org/ticket/21096
        global $wp_post_types;

        $shop_page  = get_post( me_get_page_id( 'listings' ) );

        $wp_post_types['listing']->ID           = $shop_page->ID;
        $wp_post_types['listing']->post_title   = $shop_page->post_title;
        $wp_post_types['listing']->post_name    = $shop_page->post_name;
        $wp_post_types['listing']->post_type    = $shop_page->post_type;
        $wp_post_types['listing']->ancestors    = get_ancestors( $shop_page->ID, $shop_page->post_type );

        // Fix conditional Functions like is_front_page
        $query->is_singular          = false;
        $query->is_post_type_archive = true;
        $query->is_archive           = true;
        $query->is_page              = true;

        // Remove post type archive name from front page title tag
        add_filter( 'post_type_archive_title', '__return_empty_string', 5 );

    // Only apply to product categories, the product post archive, the shop page, product tags, and product attribute taxonomies
    } elseif ( ! $query->is_post_type_archive( 'listing' ) && ! $query->is_tax( get_object_taxonomies( 'listing' ) ) ) {
        return;
    }
}
add_action('pre_get_posts', 'me_pre_get_posts' );

function me_products_plugin_query_vars($vars)
{
    $vars[] = 'order-id';

    return $vars;
}
add_filter('query_vars', 'me_products_plugin_query_vars');

/**
 * Returns the page id
 *
 * @access public
 * @param  string $page
 * @return int
 */
function me_get_page_id( $page ) {
    $options = ME_Options::get_instance();
    $page_id = $options->get_option('me_'. $page .'_page_id');
    return $page_id ? absint($page_id) : -1 ;
}

/**
 * Returns the endpoint name by query_var.
 *
 * @access public
 * @param  string $query_var
 * @return string
 */
function me_get_endpoint_name($query_var) {
    $current_endpoints = me_setting_endpoint_name();
    $query_var = str_replace('-', '_', $query_var);
    return $current_endpoints[$query_var];
}

/**
 * Returns the default endpoints.
 *
 * @access public
 * @return array of endpoints
 */
function me_get_default_endpoints() {
    $endpoint_arr = array(
        'forgot_password'   => 'forgot-password',
        'reset_password'    => 'reset-password',
        'register'          => 'register',
        'edit_profile'      => 'edit-profile',
        'change_password'   => 'change-password',
        'listings'          => 'listings',
        'orders'            => 'orders',
        'order_id'           => 'order',
        'transactions'      => 'transactions',
        'transaction'       => 'transaction',
    );
    return $endpoint_arr;
}

/**
 * Renames endpoints and returns them.
 *
 * @access public
 * @return array of endpoints
 */
function me_setting_endpoint_name() {
    $me_options = ME_Options::get_instance();
    $endpoint_arr = me_get_default_endpoints();
    foreach($endpoint_arr as $key => $value){
        $option_value = $me_options->get_option( 'ep_' . $key ) ;
        if( isset($option_value) && !empty($option_value) && $option_value != $value )
            $endpoint_arr[$key] = $option_value;
    }
    return $endpoint_arr;
}


/**
 * add account endpoint
 */
function me_init_endpoint() {
    $endpoint_arr = me_setting_endpoint_name();
    foreach($endpoint_arr as $key => $value){
        add_rewrite_endpoint($value, EP_ROOT | EP_PAGES, str_replace('_', '-', $key));
    }

    // $page = get_page_by_path( 'process-payment' );
    $page_id = me_get_page_id( 'confirm_order' );
    $page = get_post($page_id);
    // $page_title = get_page_template_slug($page_id);
    $order_endpoint = me_get_endpoint_name('order-id');
    if($page) {
        add_rewrite_rule( '^/'.$page->post_name.'/'.$order_endpoint.'/([^/]*)/?','index.php?page_id='.$page_id.'&order-id=$matches[1]','top');
    }

    $endpoints = array('orders', 'transactions', 'listings' );
    foreach($endpoints as $endpoint){
        add_rewrite_rule('^(.?.+?)/' . me_get_endpoint_name($endpoint) . '/page/?([0-9]{1,})/?$', 'index.php?pagename=$matches[1]&paged=$matches[2]&' . $endpoint, 'top');
    }

    // add_rewrite_rule('^(.?.+?)/' . me_get_endpoint_name($endpoint) . '/page/?([0-9]{1,})/?$', 'index.php?pagename=$matches[1]&paged=$matches[2]&' . $endpoint, 'top');

    // add_rewrite_rule('^(.?.+?)/' . me_get_endpoint_name($endpoint) . '/page/?([0-9]{1,})/?$', 'index.php?pagename=$matches[1]&paged=$matches[2]&' . $endpoint, 'top');

}
add_action('init', 'me_init_endpoint');

/**
 * Filter listing query
 * @since 1.0
 */
function me_filter_listing_query($query) {
    // We only want to affect the main query
    if (!$query->is_main_query()) {
        return $query;
    }

    if (!$query->is_post_type_archive('listing') && !$query->is_tax(get_object_taxonomies('listing'))) {
        return $query;
    }

    $query = me_filter_price_query($query);
    $query = me_filter_listing_type_query($query);
    $query = me_sort_listing_query($query);

    return $query;
}
add_filter('pre_get_posts', 'me_filter_listing_query');

/**
 * Filter query listing by price
 * @param object $query The WP_Query Object
 * @since 1.0
 */
function me_filter_price_query($query) {
    if (!empty($_GET['price-min']) && !empty($_GET['price-max'])) {
        $min_price                                       = $_GET['price-min'];
        $max_price                                       = $_GET['price-max'];
        $query->query_vars['meta_query']['filter_price'] = array(
            'key'     => 'listing_price',
            'value'   => array($min_price, $max_price),
            'type'    => 'numeric',
            'compare' => 'BETWEEN',
        );
    }
    return $query;
}

/**
 * Filter query listing by listing type
 * @param object $query The WP_Query Object
 * @since 1.0
 */
function me_filter_listing_type_query($query) {
    if (!empty($_GET['type'])) {
        $query->query_vars['meta_query']['filter_type'] = array(
            'key'     => '_me_listing_type',
            'value'   => $_GET['type'],
            'compare' => '=',
        );
    }
    return $query;
}


/**
 * Sort the listing
 * @param object $query The WP_Query Object
 * @since 1.0
 */
function me_sort_listing_query($query) {
    if (!empty($_GET['orderby'])) {
        switch ($_GET['orderby']) {
        case 'date':
            $query->set('orderby', 'date');
            break;
        case 'price':
            $query->set('meta_key', 'listing_price');
            $query->set('orderby', 'meta_value_num');
            $query->set('order', 'asc');
            break;
        case 'price-desc':
            $query->set('orderby', 'meta_value_num');
            $query->set('order', 'desc');
            break;
        case 'rating':
            $query->set('meta_key', '_me_rating');
            $query->set('orderby', 'meta_value_num');
            $query->set('order', 'desc');
        }
    }
    return $query;
}