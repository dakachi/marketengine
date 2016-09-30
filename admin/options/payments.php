<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

return array(
    'general'      => array(
        'title'    => __("General", "enginethemes"),
        'slug'     => 'general',
        'type'     => 'section',
        'template' => array(
            'test-mode' => array(
                'label'       => __("Test Mode", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'test-mode',
                'type'        => 'switch',
                'name'        => 'test-mode',
                'template'    => array(),
            ),
            'checkout-page' => array(
                'label'       => __("Checkout Page", "enginethemes"),
                'description' => __("Choose a page to display as Checkout Page", "enginethemes"),
                'slug'        => 'checkout-page',
                'type'        => 'select',
                'name'        => 'me_checkout_page_id',
                'data'        => marketengine_get_list_of_page(),
                'template'    => array(),
            ),
            'checkout-endpoints' => array(
                'label'       => __("Checkout Endpoints", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'checkout-endpoints',
                'type'        => 'multi_field',
                'name'        => 'checkout-endpoints',
                'template'    => array(),
            ),
            'ep-button' => array(
                'label'       => __("Save changes", "enginethemes"),
                'type'        => 'button',
                'name'        => 'ep-button',
                'slug'        => 'ep-button',
                'template'    => array(),
            ),
        ),
    ),
    'paypal'      => array(
        'title'    => __("Paypal", "enginethemes"),
        'slug'     => 'paypal',
        'type'     => 'section',
        'template' => array(
            'app-api' => array(
                'label'       => __("App API", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'app-api',
                'type'        => 'textbox',
                'name'        => 'app-api',
                'template'    => array(),
            ),
            'username' => array(
                'label'       => __("Username", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'username',
                'type'        => 'textbox',
                'name'        => 'username',
                'template'    => array(),
            ),
            'password' => array(
                'label'       => __("Password", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'password',
                'type'        => 'textbox',
                'name'        => 'password',
                'ispassword'  => true,
                'template'    => array(),
            ),
            'signature' => array(
                'label'       => __("Signature", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'signature',
                'type'        => 'textbox',
                'name'        => 'signature',
                'template'    => array(),
            ),
        ),
    ),
);