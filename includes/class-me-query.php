<?php
/**
 * Handle redirects before content is output - hooked into template_redirect so is_page works.
 */
function me_template_redirect() {
    global $wp_query, $wp;

    // When default permalinks are enabled, redirect shop page to post type archive url
    if (!empty($_GET['page_id']) && '' === get_option('permalink_structure') && $_GET['page_id'] == me_get_page_id('listings')) {
        wp_safe_redirect(get_post_type_archive_link('listing'));
        exit;
    }
}
add_action('template_redirect', 'me_template_redirect');

function listing_body_classes( $classess ) {
    $classes[] = 'marketengine-snap-column marketengine-snap-column-4';
    return $classes;
}

/**
 *
 */
function me_pre_get_posts($query) {
    // Only affect the main query
    if (!$query->is_main_query()) {
        return;
    }

    if(is_archive('listing') && !is_admin()) {
        $query->set( 'post_status', 'publish');
    }

    if($query->is_author()) {
        $query->set( 'post_type', 'listing');
        $query->set( 'post_status', 'publish');
    }

    if ($GLOBALS['wp_rewrite']->use_verbose_page_rules && isset($query->queried_object->ID) && $query->queried_object->ID === me_get_page_id('listings')) {
        $query->set('post_type', 'listing');
        $query->set('page', '');
        $query->set('pagename', '');

        // Fix conditional Functions
        $query->is_archive           = true;
        $query->is_post_type_archive = true;
        $query->is_singular          = false;
        $query->is_page              = false;
    }

    // Fix for endpoints on the homepage
    if ($query->is_home() && 'page' === get_option('show_on_front') && absint(get_option('page_on_front')) !== absint($query->get('page_id'))) {
        $_query = wp_parse_args($query->query);
        if (!empty($_query)) {
            $query->is_page     = true;
            $query->is_home     = false;
            $query->is_singular = true;
            $query->set('page_id', (int) get_option('page_on_front'));
            add_filter('redirect_canonical', '__return_false');
        }
    }

    // When orderby is set, WordPress shows posts. Get around that here.
    if ($query->is_home() && 'page' === get_option('show_on_front') && absint(get_option('page_on_front')) === me_get_page_id('listings')) {
        $_query = wp_parse_args($query->query);
        if (empty($_query) || !array_diff(array_keys($_query), array('preview', 'page', 'paged', 'cpage', 'orderby'))) {
            $query->is_page = true;
            $query->is_home = false;
            $query->set('page_id', (int) get_option('page_on_front'));
            $query->set('post_type', 'listing');
        }
    }

    // Special check for shops with the listing archive on front
    if ($query->is_page() && 'page' === get_option('show_on_front') && absint($query->get('page_id')) === me_get_page_id('listings')) {
        add_filter('body_class', 'listing_body_classes');
    }

    global $wp_post_types;
    if( is_search() ) {
        $wp_post_types['listing']->exclude_from_search = true;
    }
}
add_action('pre_get_posts', 'me_pre_get_posts');

function me_products_plugin_query_vars($vars) {
    $vars[] = 'order-id';
    $vars[] = 'keyword';

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
function me_get_page_id($page) {
    $page_id = me_option('me_' . $page . '_page_id');
    $page_obj = get_post($page_id);
    return $page_id && isset($page_obj) ? absint($page_id) : -1;
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
    $query_var         = str_replace('-', '_', $query_var);
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
        'forgot_password' => 'forgot-password',
        'reset_password'  => 'reset-password',
        'register'        => 'register',
        'edit_profile'    => 'edit-profile',
        'change_password' => 'change-password',
        'listings'        => 'listings',
        'orders'          => 'orders',
        'order_id'        => 'order',
        'purchases'       => 'purchases',
        'pay'             => 'pay',
        'listing_id'      => 'listing-id',
        'seller_id'       => 'seller',
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
    $endpoint_arr = me_get_default_endpoints();
    foreach ($endpoint_arr as $key => $value) {
        $option_value = me_option('ep_' . $key);
        if (isset($option_value) && !empty($option_value) && $option_value != $value) {
            $endpoint_arr[$key] = $option_value;
        }
    }
    return $endpoint_arr;
}

/**
 * Rewrite page url.
 *
 * @access public
 */
function me_page_rewrite_rule($rewrite_args) {
    foreach ($rewrite_args as $key => $value) {
        if ($value['page_id'] > -1) {
            $page = get_post($value['page_id']);
            add_rewrite_rule('^/' . $page->post_name . '/' . $value['endpoint_name'] . '/([^/]*)/?', 'index.php?page_id=' . $value['page_id'] . '&' . $value['query_var'] . '=$matches[1]', 'top');
        }
    }
}

/**
 * add account endpoint
 */
function me_init_endpoint() {
    $endpoint_arr = me_setting_endpoint_name();
    foreach ($endpoint_arr as $key => $value) {
        add_rewrite_endpoint($value, EP_ROOT | EP_PAGES, str_replace('_', '-', $key));
    }

    $rewrite_args = array(
        array(
            'page_id'       => me_get_page_id('confirm_order'),
            'endpoint_name' => me_get_endpoint_name('order-id'),
            'query_var'     => 'order-id',
        ),

        array(
            'page_id'       => me_get_page_id('cancel_order'),
            'endpoint_name' => me_get_endpoint_name('order-id'),
            'query_var'     => 'order-id',
        ),
        array(
            'page_id'       => me_get_page_id('me_checkout'),
            'endpoint_name' => me_get_endpoint_name('pay'),
            'query_var'     => 'pay',
        )
    );
    me_page_rewrite_rule($rewrite_args);

    $endpoints = array('orders', 'purchases', 'listings');
    foreach ($endpoints as $endpoint) {
        add_rewrite_rule('^(.?.+?)/' . me_get_endpoint_name($endpoint) . '/page/?([0-9]{1,})/?$', 'index.php?pagename=$matches[1]&paged=$matches[2]&' . $endpoint, 'top');
    }

    $edit_listing_page = me_get_page_id('edit_listing');
    if( $edit_listing_page > -1) {
        $page = get_post($edit_listing_page);
        add_rewrite_rule('^/' . $page->post_name . '/'. me_get_endpoint_name('listing_id') .'/?([0-9]{1,})/?$', 'index.php?page_id='.$edit_listing_page.'&listing_id'.'=$matches[1]', 'top');
    }

    rewrite_order_url();
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

    $query = me_sort_listing_query($query);
    $query = me_filter_price_query($query);
    $query = me_filter_listing_type_query($query);
    $query = me_filter_search_query($query);

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

        $query->query_vars['meta_query']['type'] = array(
            'key'     => '_me_listing_type',
            'value'   => 'purchasion',
            'compare' => '=',
        );

        $query->query_vars['meta_query']['relation'] = 'AND';

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
 * Filter query listing by keyword
 * @param object $query The WP_Query Object
 * @since 1.0
 */
function me_filter_search_query($query) {
    if (!empty($_GET['keyword'])) {
        $query->query_vars['s'] = $_GET['keyword'];
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
            $meta_query = array(
                'relation' => 'AND',
                'filter_price' => array(
                    'key' => 'listing_price',
                ),
                'type' => array(
                    'key'     => '_me_listing_type',
                    'value'   => 'purchasion',
                    'compare' => '=',
                ),
            );
            $query->set('meta_query', $meta_query);
            $query->set('orderby', 'meta_value_num');
            $query->set('order', 'asc');
            break;
        case 'price-desc':
            $query->set('meta_key', 'listing_price');
            $meta_query = array(
                'relation' => 'AND',
                'filter_price' => array(
                    'key' => 'listing_price',
                ),
                'type' => array(
                    'key'     => '_me_listing_type',
                    'value'   => 'purchasion',
                    'compare' => '=',
                ),
            );
            $query->set('meta_query', $meta_query);
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

function rewrite_order_url() {
    $order_endpoint = me_get_endpoint_name('order_id');
    add_filter('post_type_link', 'custom_me_order_link', 1, 3);

    add_rewrite_rule( $order_endpoint . '/([0-9]+)/?$', 'index.php?post_type=me_order&p=$matches[1]', 'top' );
}

function custom_me_order_link($order_link, $post = 0) {
    if ($post->post_type == 'me_order') {
        if(get_option('permalink_structure')) {
            $pos = strrpos($order_link, '%/');
            $order_link = substr($order_link, 0, $pos+1);
        }
        return str_replace('%post_id%', $post->ID, $order_link);
    } else {
        return $order_link;
    }
}