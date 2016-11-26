<?php
/**
 * Related to Listing Functions
 * @package Listing
 * @category Function
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get the listing object from wordpress post
 * @param object|int $post The wp_post id or object
 *
 * @package Includes/Listing
 * @category Function
 *
 * @since 1.0
 * 
 * @return ME_Listing | null Return ME_Listing object if post->post_type is listing, if not return null
 */
function me_get_listing($post = null) {
    if (null === $post) {
        global $post;
    }

    if (is_numeric($post)) {
        $post = get_post($post);
    }

    return ME_Listing_Factory::instance()->get_listing($post);
}
/**
 * Retrieve supported listing types
 * 
 * @package Includes/Listing
 * @category Function
 * 
 * @since 1.0
 * @return array Array of listing type
 */
function me_get_listing_types() {
    $purchasion_title = me_option('purchasion-title');
    $contact_title = me_option('contact-title');
    $listing_types = array(
        'purchasion' => $purchasion_title ? $purchasion_title : __("Selling", "enginethemes"),
        'contact'    => $contact_title ? $contact_title : __("Offering", "enginethemes"),
    );
    return apply_filters('me_get_listing_types', $listing_types);
}

/**
 * Retrieve listing type label
 * @param string The listing type keyword
 *
 * @package Includes/Listing
 * @category Function
 * 
 * @since 1.0
 * @return string
 */
function me_get_listing_type_label($type) {
    $types = me_get_listing_types();
    return $types[$type];
}

/**
 * MarketEngine Get Listing Type Categories
 * 
 * Retrieve the categories list supported in each listing type
 *
 * @package Includes/Listing
 * @category Function
 * 
 * @since 1.0
 * @return array Array of category id the listing type support
 */
function me_get_listing_type_categories() {
    $purchase_cats = me_option('purchasion-available');
    $contact_cats  = me_option('contact-available');
    $categories = array(
        'contact' => empty($contact_cats) ? array() : $contact_cats,
        'purchasion' => empty($purchase_cats) ? array() : $purchase_cats
    );
    return apply_filters('marketengine_listing_type_categories', $categories);
}

/**
 * MarketEngine Get Listing Status List
 *
 * Retrieve marketengine listing status list
 *
 * @package Includes/Listing
 * @category Function
 * 
 * @since 1.0
 * @return array
 */
function me_listings_status_list() {
    $listing_status = array(
        'publish'     => __("Published", "enginethemes"),
        // 'me-pending'  => __("Pending", "enginethemes"),
        'me-archived' => __("Archived", "enginethemes"),
        // 'draft'       => __("Draft", "enginethemes"),
        // 'me-paused'   => __("Paused", "enginethemes"),
    );
    return apply_filters('marketengine_listing_status_list', $listing_status);
}

function me_get_user_rate_listing_score($listing_id, $user_id) {
    $args = array(
        'post_id'        => $listing_id,
        'type'           => 'review',
        'number'         => 1,
        'comment_parent' => 0,
    );

    if($user_id) {
        $args['user_id'] = $user_id;
    }

    $comments = get_comments($args);

    if(!empty($comments)) {
        return get_comment_meta( $comments[0]->comment_ID, '_me_rating_score', true );
    }
    return 0;
}

function me_filter_order_count_result( $results ) {
    $temp = array();
    foreach( $results as $key => $result) {
        $temp[$result->status] = $result->count;
    }

    return $temp;
}

function me_get_listing_categories($args = array('parent' => 0 , 'hide_empty' => false))
{
    $result   = array();
    $termlist = get_terms('listing_category', $args );

    foreach ($termlist as $term) {
        $result[$term->term_id] =  $term->name;
    }

    return $result;
}