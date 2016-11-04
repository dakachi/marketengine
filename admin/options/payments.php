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

            'cancel-order-page' => array(
                'label'       => __("Cancel Order Page", "enginethemes"),
                'description' => __("Choose a page to display as Cancel Order Page", "enginethemes"),
                'slug'        => 'me_cancel_order',
                'type'        => 'select',
                'name'        => 'me_cancel_order_page_id',
                'data'        => marketengine_get_list_of_page(),
                'template'    => array(),
            ),
            'dispute-page' => array(
                'label'       => __("Resolution Center Page", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'me_dispute',
                'type'        => 'select',
                'name'        => 'me_dispute_page_id',
                'data'        => marketengine_get_list_of_page(),
                'template'    => array(),
            ),
            'commission_fee' => array(
                'label'       => __("Commission Fee", "enginethemes"),
                'description' => __("The commission fee will charge the seller", "enginethemes"),
                'slug'        => 'paypal-commission-fee',
                'type'        => 'number',
                'class_name'  => 'positive',
                'attributes'  => array(
                    'min'       => 0,
                ),
                'name'        => 'paypal-commission-fee'
            ),
            'dispute-time-limit' => array(
                'label'       => __("Displute Time Limit", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'dispute-time-limit',
                'type'        => 'number',
                'class_name'  => 'no-zero positive',
                'attributes'  => array(
                    'min'       => 1,
                ),
                'name'        => 'dispute-time-limit'
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
            'receiver-email' => array(
                'label'       => __("Receiver Email", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'paypal-receiver-email',
                'type'        => 'textbox',
                'name'        => 'paypal-receiver-email',
                'template'    => array(),
            ),
        )
    ),
    'payment-currency'      => array(
        'title'    => __("Currency", "enginethemes"),
        'slug'     => 'currency-section',
        'type'     => 'section',
        'template' => array(
            'currency-sign' => array(
                'label'       => __("Currency Sign", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'payment-currency-sign',
                'type'        => 'textbox',
                'name'        => 'payment-currency-sign'
            ),
            'currency-sign-postion' => array(
                'label'       => __("", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'currency-sign-postion',
                'type'        => 'switch',
                'name'        => 'currency-sign-postion',
                'text'        => array( __('Left', 'enginethemes'), __('Right', 'enginethemes') ),
                'template'    => array(),
            ),
            'currency-lable' => array(
                'label'       => __("Currency Lable", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'payment-currency-lable',
                'type'        => 'textbox',
                'name'        => 'payment-currency-lable',
            ),
            'currency-code' => array(
                'label'       => __("Currency Code", "enginethemes"),
                'description' => __("", "enginethemes"),
                'slug'        => 'payment-currency-code',
                'type'        => 'textbox',
                'name'        => 'payment-currency-code'
            ),
        ),
    ),
);