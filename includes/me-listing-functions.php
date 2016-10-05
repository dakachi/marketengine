<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function me_get_listing($listing = null, $output = OBJECT, $filter = 'raw') {
    if (empty($listing) && isset($GLOBALS['post'])) {
        $listing = $GLOBALS['post'];
    }

    if ($listing instanceof ME_Listing) {
        $_listing = $listing;
    } elseif (is_object($listing)) {
        if (empty($listing->filter)) {
            $_listing = sanitize_post($listing, 'raw');
            $_listing = new ME_Listing($_listing);
        } elseif ('raw' == $listing->filter) {
            $_listing = new ME_Listing($listing);
        } else {
            $_listing = ME_Listing::get_instance($listing->ID);
        }
    } else {
        $_listing = ME_Listing::get_instance($listing);
    }

    if (!$_listing) {
        return null;
    }

    $_listing = $_listing->filter($filter);

    if ($output == ARRAY_A) {
        return $_listing->to_array();
    } elseif ($output == ARRAY_N) {
        return array_values($_listing->to_array());
    }

    return $_listing;
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