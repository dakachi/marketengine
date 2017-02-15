<?php

/**
 * Set up environment for my plugin's tests suite.
 */

/**
 * The path to the WordPress tests checkout.
 */
define('WP_TESTS_DIR', '/wordpress-developer/tests/phpunit/');

/**
 * The path to the main file of the plugin to test.
 */
define('TEST_PLUGIN_FILE', dirname(__FILE__));

/**
 * The WordPress tests functions.
 *
 * We are loading this so that we can add our tests filter
 * to load the plugin, using tests_add_filter().
 */
require_once WP_TESTS_DIR . 'includes/functions.php';

/**
 * Manually load the plugin main file.
 *
 * The plugin won't be activated within the test WP environment,
 * that's why we need to load it manually.
 *
 * You will also need to perform any installation necessary after
 * loading your plugin, since it won't be installed.
 */
function _manually_load_plugin()
{

    // require TEST_PLUGIN_FILE . '/marketengine.php';
    require TEST_PLUGIN_FILE . '/marketengine.php';
}
tests_add_filter('muplugins_loaded', '_manually_load_plugin');

/**
 * Sets up the WordPress test environment.
 *
 * We've got our action set up, so we can load this now,
 * and viola, the tests begin.
 */
function me_test_create_basic_contact_listing($author = 0)
{
    $listing_data = array(
        'post_author'  => $author,
        'meta_input'   => array
        (
            '_me_listing_type' => 'contact',
        ),

        'post_type'    => 'listing',
        'post_title'   => 'Listing 1',
        'post_content' => 'Listing 1',
        'post_status'  => 'publish',
    );
    return wp_insert_post($listing_data);
}

function me_test_create_basic_purchase_listing($author = 0)
{
    $listing_data = array(
        'post_author'  => $author,
        'meta_input'   => array
        (
            'listing_price'    => 2000,
            'pricing_unit'     => 'per_unit',
            '_me_listing_type' => 'purchasion',
        ),
        'post_type'    => 'listing',
        'post_title'   => 'Listing 1',
        'post_content' => 'Listing 1',
        'post_status'  => 'publish',
    );
    return wp_insert_post($listing_data);
}

function me_test_create_basic_order($listing, $buyer)
{
    $order_data = array(
        //'post_author' => 10,
        'customer_note' => 'Order note',
    );

    $order_id = marketengine_insert_order($order_data);
    $order    = new ME_Order($order_id);

    $listing = marketengine_get_listing($listing);
    $item_id = $order->add_listing($listing);
    return $order_id;
}

require WP_TESTS_DIR . 'includes/bootstrap.php';
