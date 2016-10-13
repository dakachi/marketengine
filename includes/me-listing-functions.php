<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function me_get_listing($post = null)
{
    if (null === $post) {
        global $post;
    }

    if(is_numeric($post)) {
        $post = get_post($post);
    }
    
    return ME_Listing_Factory::instance()->get_listing($post);
}

function me_get_listing_types() {
    $listing_types = array(
        'purchasion' => __("Selling", "enginethemes"),
        'contact'    => __("Offering", "enginethemes"),
    );
    return apply_filters('me_get_listing_types', $listing_types);
}

function get_listing_type_by_cat($cat_id) {
    $default_listing_types = me_get_listing_types();
    $type                  = array_rand($default_listing_types);
    return array($type => $default_listing_types[$type]);
}

function me_get_categories($taxonomy = '') {
    if (!taxonomy_exists($taxonomy)) {
        return;
    }

    $terms = get_terms(array(
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
    ));
    return $terms;
}

/**
 * MarketEngine Get Listing Status List
 *
 * Retrieve marketengine listing status list
 *
 * @since 1.0
 * @return array
 */
function me_listings_status_list() {
    $listing_status = array(
        'publish'     => __("Publish", "enginethemes"),
        'me-pending'  => __("Pending", "enginethemes"),
        'me-archived'  => __("Archived", "enginethemes"),
        'draft'  => __("Draft", "enginethemes"),
        'me-pause'  => __("Pause", "enginethemes"),
    );
    return apply_filters('marketengine_listing_status_list', $listing_status);
}