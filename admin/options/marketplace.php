<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

return apply_filters('marketengine_marketplace_options',
    array(
        'general' => array(
            'title'        => __("General", "enginethemes"),
            'slug'         => 'general-section',
            'type'         => 'section',
            'template'     => array(
                'user-email-confirmation' => array(
                    'label'       => __("Email Confirmation", "enginethemes"),
                    'description' => __("", "enginethemes"),
                    'slug'        => 'user-email-confirmation',
                    'type'        => 'switch',
                    'name'        => 'user-email-confirmation',
                    'template'    => array(),
                ),
                'commission_fee'          => array(
                    'label'       => __("Commission Fee", "enginethemes"),
                    'description' => __("The commission fee will charge the seller (by percentage)", "enginethemes"),
                    'slug'        => 'paypal-commission-fee',
                    'type'        => 'number',
                    'class_name'  => 'positive',
                    'attributes'  => array(
                        'min' => 0,
                    ),
                    'name'        => 'paypal-commission-fee',
                ),

                'currency'               => array(
                    'label'              => __("Currency Options", "enginethemes"),
                    'description'        => __("Setup the current market currency for the listing price", "enginethemes"),
                    'slug'               => 'user-account-endpoint',
                    'type'               => 'multi_field',
                    'name'               => 'user-account-endpoint',
                    'template'           => array(
                        'currency-code'         => array(
                            'label'       => __("Currency Code", "enginethemes"),
                            'description' => __("The International Standard for currency code supported by Paypal Adaptive", "enginethemes"),
                            'slug'        => 'payment-currency-code',
                            'type'        => 'textbox',
                            'name'        => 'payment-currency-code',
                        ),
                        'currency-sign'         => array(
                            'label'       => __("Currency Sign", "enginethemes"),
                            'description' => __("The currency symbol display beside the listing price", "enginethemes"),
                            'slug'        => 'payment-currency-sign',
                            'type'        => 'textbox',
                            'name'        => 'payment-currency-sign',
                        ),
                        'currency-sign-postion' => array(
                            'label'       => __("Currency Position", "enginethemes"),
                            'description' => __("The position of the currency sign", "enginethemes"),
                            'slug'        => 'currency-sign-postion',
                            'type'        => 'switch',
                            'name'        => 'currency-sign-postion',
                            'text'        => array(__('Left', 'enginethemes'), __('Right', 'enginethemes')),
                            'template'    => array(),
                        ),
                        'currency-lable'        => array(
                            'label'       => __("Currency Lable", "enginethemes"),
                            'description' => __("The lable of currency", "enginethemes"),
                            'slug'        => 'payment-currency-label',
                            'type'        => 'textbox',
                            'name'        => 'payment-currency-label',
                        ),

                        // 'thousand-sep' =>  array(
                        // 	'label' => __("Thousand Separator", "enginethemes"),
                        // 	'description' => __("The thousand seperator of displayed price", "enginethemes"),
                        //     'slug'        => 'thousand-sep',
                        //     'type'        => 'textbox',
                        //     'name'        => 'thousand-sep',
                        // ),
                        // 'dec-sep' =>  array(
                        // 	'label' => __("Decimal Separator", "enginethemes"),
                        // 	'description' => __("The decimal seperator of displayed price", "enginethemes"),
                        //     'slug'        => 'dec-sep',
                        //     'type'        => 'textbox',
                        //     'name'        => 'dec-sep',
                        // ),
                        // 'number-of-dec' =>  array(
                        // 	'label' => __("Number of Decimals", "enginethemes"),
                        // 	'description' => __("The number of decimal point show in displayed price", "enginethemes"),
                        //     'slug'        => 'number-of-sep',
                        //     'type'        => 'textbox',
                        //     'name'        => 'number-of-sep',
                        // ),
                        'dispute-time-limit' => array(
                            'label'       => __("Auto complete order - After XX days", "enginethemes"),
                            'description' => __("The duration to close completed order (by day)", "enginethemes"),
                            'slug'        => 'dispute-time-limit',
                            'type'        => 'number',
                            'class_name'  => 'no-zero positive',
                            'attributes'  => array(
                                'min' => 1,
                            ),
                            'name'        => 'dispute-time-limit',
                        ),
                    ),
                ),
            ),
		),
        'listing-type' => array(
            'title'    => __("Listing Type", "enginethemes"),
            'slug'     => 'listing-type-section',
            'type'     => 'section',
            'template' => array(

            ),
        ),
        'sample-data'  => array(
            'title'    => __("Sample Data", "enginethemes"),
            'slug'     => 'sample-data-section',
            'type'     => 'section',
            'template' => array(

            ),
        ),
    )
);