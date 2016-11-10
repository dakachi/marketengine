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
            
            'receiver-email' => array(
                'label'       => __("Receiver Email", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'paypal-receiver-email',
                'type'        => 'textbox',
                'name'        => 'paypal-receiver-email',
                'template'    => array(),
            ),

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
                'type'        => 'password',
                'name'        => 'paypal-api-password',
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
        ),
    ),
);
