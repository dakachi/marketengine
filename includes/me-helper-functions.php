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
function me_get_option_page_id($page_option_name)
{
    $page_id  = absint(me_option('me_' . $page_option_name . '_page_id'));
    $page = get_post($page_id);
    if(!$page) {
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
function me_get_endpoint_name($query_var)
{
    $query_var = str_replace('-', '_', $query_var);
    return me_option('ep_' . $query_var, 'order');
}