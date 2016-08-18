<?php

/**
 * add account endpoint
 */
function me_init_endpoint() {
    add_rewrite_endpoint('forgot-password', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('reset-password', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('register', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('edit-profile', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('change-password', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('listings', EP_ROOT | EP_PAGES);
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