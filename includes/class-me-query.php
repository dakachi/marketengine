<?php
add_action('init', 'me_init');
function me_init() {
    add_rewrite_endpoint('forgot-password', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('reset-password', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('register', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('edit-profile', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('change-password', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('listings', EP_ROOT | EP_PAGES);
}

// todo: query listing order by date, rating, price
// todo: filter listing by price
// todo: filter listing by listing type

function me_filter_listing_query($query) {
	// We only want to affect the main query
	if ( ! $query->is_main_query() ) {
		return;
	}

	if(! $query->is_post_type_archive( 'listing' ) && ! $query->is_tax( get_object_taxonomies( 'listing' ) )) {
		return $query;
	}
	
	$query = me_filter_price_query($query);
	$query = me_sort_listing_query($query);
	
	return $query;
}
add_filter( 'pre_get_posts', 'me_filter_listing_query');

function me_filter_price_query($query) {
	$min_price = $_GET['price-min'];
	$max_price = $_GET['price-max'];
	$query->set('meta_query', array(
		array(
			'key'     => 'listing_price',
			'value'   => array( $min_price, $max_price ),
			'type'    => 'numeric',
			'compare' => 'BETWEEN',
		)
	));
	$query->set('meta_key', 'listing_price');
	
	return $query;
}

function me_sort_listing_query($query) {
	$query->set('orderby', 'meta_value_num');
	$query->set('order', 'asc');
	return $query;
}