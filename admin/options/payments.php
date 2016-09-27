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
        'checkout-endpoints' => array(
            'label'       => __("Checkout Endpoints", "enginethemes"),
            'description' => __("", "enginethemes"),
            'slug'        => 'checkout-endpoints',
            'type'        => 'multi_field',
            'name'        => 'checkout-endpoints',
            'template'    => array(
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
    'payment-endpoint'      => array(
        'title'    => __("Endpoint Settings", "enginethemes"),
        'slug'     => 'payment-endpoint',
        'type'     => 'section',
        'template' => array(
        ),
    ),
);