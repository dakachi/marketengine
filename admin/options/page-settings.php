<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

return array(
    'user-account-page' => array(
        'label'       => __("User Account Page", "enginethemes"),
        'description' => __("Choose a page to display as User Account Page", "enginethemes"),
        'slug'        => 'user-account-page',
        'type'        => 'select',
        'name'        => 'user-account-page',
        'data'        => marketengine_get_list_of_page(),
        'template'    => array(),
    ),
    'checkout-page' => array(
        'label'       => __("Checkout Page", "enginethemes"),
        'description' => __("Choose a page to display as Checkout Page", "enginethemes"),
        'slug'        => 'checkout-page',
        'type'        => 'select',
        'name'        => 'checkout-page',
        'data'        => marketengine_get_list_of_page(),
        'template'    => array(),
    ),
    'ep-button' => array(
        'label'       => __("Save changes", "enginethemes"),
        'type'        => 'button',
        'name'        => 'btn-page-setting',
        'slug'        => 'btn-page-setting',
        'template'    => array(),
    ),
);