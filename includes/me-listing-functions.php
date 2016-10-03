<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function me_get_listing_types() {
    $listing_types = array(
    	'purchasion' => __("Selling", "enginethemes"),
        'contact'    => __("Offering", "enginethemes")
    );
    return apply_filters('me_get_listing_types', $listing_types);
}

function get_listing_type_by_cat($cat_id) {
	$default_listing_types = me_get_listing_types();
	$type = array_rand($default_listing_types);
	return array($type => $default_listing_types[$type]);
}

function me_get_categories( $taxonomy = '' ) {
	if( !taxonomy_exists( $taxonomy ) ) {
		return;
	}

	$terms = get_terms( array(
	    'taxonomy' => $taxonomy,
	    'hide_empty' => false,
	) );
	return $terms;
}