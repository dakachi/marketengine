<?php
/**
 * This file containt helper functions
 * @package Includes/Helper
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Retrieve page id base on option name
 *
 * @access public
 * @param  string $page_option_name The page option name
 * @package Includes/Helper
 * @category Function
 *
 * @return int| null Page Id if exist or null if page not existed
 */
function marketengine_get_option_page_id($page_option_name)
{
    $page_id = absint(marketengine_option('marketengine_' . $page_option_name . '_page_id'));
    $page    = get_post($page_id);
    if (!$page) {
        return -1;
    }
    return $page_id;
}

/**
 * Returns the endpoint name by query_var.
 *
 * @access public
 * @param  string $query_var
 * @return string
 */
function marketengine_get_endpoint_name($query_var)
{
    $query_var        = str_replace('-', '_', $query_var);
    $defaults         = marketengine_default_endpoints();
    $default_endpoint = isset($defaults[$query_var]) ? $defaults[$query_var] : '';

    $endpoint = marketengine_option('ep_' . $query_var);
    return $endpoint ? $endpoint : $default_endpoint;
}

/**
 * Returns the default endpoints.
 *
 * @access public
 * @return array of endpoints
 */
function marketengine_default_endpoints()
{
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
