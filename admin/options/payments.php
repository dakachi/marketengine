<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

return array(
    'general'      => array(
        'title'    => __("General", "enginethemes"),
        'slug'     => 'general-section',
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
                'slug'        => 'me_checkout_form',
                'type'        => 'select',
                'name'        => 'me_checkout_page_id',
                'data'        => marketengine_get_list_of_page(),
                'template'    => array(),
            ),
            'confirm-order-page' => array(
                'label'       => __("Confirm Order Page", "enginethemes"),
                'description' => __("Choose a page to display as Confirm Order Page", "enginethemes"),
                'slug'        => 'me_confirm_order',
                'type'        => 'select',
                'name'        => 'me_confirm_order_page_id',
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
        'slug'     => 'paypal-section',
        'type'     => 'section',
        'template' => array(
            'app-api' => array(
                'label'       => __("App API", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'paypal-app-api',
                'type'        => 'textbox',
                'name'        => 'paypal-app-api',
                'template'    => array(),
            ),
            'username' => array(
                'label'       => __("Username", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'paypal-api-username',
                'type'        => 'textbox',
                'name'        => 'paypal-api-username',
                'template'    => array(),
            ),
            'password' => array(
                'label'       => __("Password", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'paypal-api-password',
                'type'        => 'textbox',
                'name'        => 'paypal-api-password',
                'ispassword'  => true,
                'template'    => array(),
            ),
            'signature' => array(
                'label'       => __("Signature", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'paypal-api-signature',
                'type'        => 'textbox',
                'name'        => 'paypal-api-signature',
                'template'    => array(),
            ),
            'receiver-email' => array(
                'label'       => __("Receiver Email", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'paypal-receiver-email',
                'type'        => 'textbox',
                'name'        => 'paypal-receiver-email',
                'template'    => array(),
            ),
        ),
    ),
);