<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

return array(
    'authentication' => array
    (
        'title'    => __("Authentication", "enginethemes"),
        'slug'     => 'authentication',
        'type'     => 'section',
        'template' => array(
            'user-account-page' => array(
                'label'       => __("User Account Page", "enginethemes"),
                'description' => __("Choose a page to display as User Account Page, page content [me_user_account]", "enginethemes"),
                'slug'        => 'user-account-page',
                'type'        => 'select',
                'name'        => 'me_user_account_page_id',
                'data'        => marketengine_get_list_of_page(),
                'template'    => array(),
            ),
            'user-account-endpoint' => array(
                'label'       => __("User Account Endpoint", "enginethemes"),
                'description' => __("Endpoints are appended to your page URLs to handle specific actions on the accounts pages and they should be unique.", "enginethemes"),
                'slug'        => 'user-account-endpoint',
                'type'        => 'multi_field',
                'name'        => 'user-account-endpoint',
                'data'        => marketengine_get_list_of_page(),
                'template'    => array(
                    'ep-register' => array(
                        'label'       => __("Register", "enginethemes"),
                        'description' => __("Endpoint for the User Account -> Register page", "enginethemes"),
                        'slug'        => 'ep-register',
                        'type'        => 'textbox',
                        'name'        => 'ep_register',
                        'placeholder' => 'register',
                        'template'    => array(),
                    ),
                    'ep-edit-profile' => array(
                        'label'       => __("Edit Profile", "enginethemes"),
                        'description' => __("Endpoint for the User Account -> Edit Profile page", "enginethemes"),
                        'slug'        => 'ep-edit-profile',
                        'type'        => 'textbox',
                        'name'        => 'ep_edit_profile',
                        'placeholder' => 'edit-profile',
                        'template'    => array(),
                    ),
                    'ep-change-password' => array(
                        'label'       => __("Change Password", "enginethemes"),
                        'description' => __("Endpoint for the User Account -> Change Password page", "enginethemes"),
                        'slug'        => 'ep-change-password',
                        'type'        => 'textbox',
                        'name'        => 'ep_change_password',
                        'placeholder' => 'change-password',
                        'template'    => array(),
                    ),
                    'ep-forgot-password' => array(
                        'label'       => __("Forgot Password", "enginethemes"),
                        'description' => __("Endpoint for the User Account -> Forgot Password page", "enginethemes"),
                        'slug'        => 'ep-forgot-password',
                        'type'        => 'textbox',
                        'name'        => 'ep_forgot_password',
                        'placeholder' => 'forgot-password',
                        'template'    => array(),
                    ),
                    'ep-reset-password' => array(
                        'label'       => __("Reset Password", "enginethemes"),
                        'description' => __("Endpoint for the User Account -> Reset Password page", "enginethemes"),
                        'slug'        => 'ep-reset-password',
                        'type'        => 'textbox',
                        'name'        => 'ep_reset_password',
                        'placeholder' => 'reset-password',
                        'template'    => array(),
                    ),
                    'ep-listings' => array(
                        'label'       => __("My Listings", "enginethemes"),
                        'description' => __("Endpoint for the User Account -> My Listings page", "enginethemes"),
                        'slug'        => 'ep-listings',
                        'type'        => 'textbox',
                        'name'        => 'ep_listings',
                        'placeholder' => 'listings',
                        'template'    => array(),
                    ),
                    
                    'ep-orders' => array(
                        'label'       => __("My Orders", "enginethemes"),
                        'description' => __("Endpoint for the User Account -> My Orders page", "enginethemes"),
                        'slug'        => 'ep-orders',
                        'type'        => 'textbox',
                        'name'        => 'ep_orders',
                        'placeholder' => 'orders',
                        'template'    => array(),
                    ),
                    'ep-purchases' => array(
                        'label'       => __("My Purchases", "enginethemes"),
                        'description' => __("Endpoint for the User Account -> My Purchases page", "enginethemes"),
                        'slug'        => 'ep-purchases',
                        'type'        => 'textbox',
                        'name'        => 'ep_purchases',
                        'placeholder' => 'purchases',
                        'template'    => array(),
                    ),
                    
                    
                ),
            ),
        ),
    ),
    'listings' => array(
        'title'    => __("Listings", "enginethemes"),
        'slug'     => 'listings',
        'type'     => 'section',
        'template' => array(
            'post-listings-page' => array(
                'label'         => __("Post Listing Page", "enginethemes"),
                'description'   => __("Choose a page to display as Post Listing Page", "enginethemes"),
                'slug'          => 'me_post_listing_form',
                'name'          => 'me_post_listing_page_id',
                'type'          => 'select',
                'data'          => marketengine_get_list_of_page(),
                'template'      => array(),
            ),
            'listings-page' => array(
                'label'         => __("Edit Listing Page", "enginethemes"),
                'description'   => __("Choose a page to display as Edit Listing Page", "enginethemes"),
                'slug'          => 'me_listings',
                'name'          => 'me_edit_listing_page_id',
                'type'          => 'select',
                'data'          => marketengine_get_list_of_page(),
                'template'      => array(),
            ),
        ),
    ),
    'payment-flow' => array(
        'title'    => __("Payment Flow", "enginethemes"),
        'slug'     => 'payment-flow',
        'type'     => 'section',
        'template' => array(
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
            'payment-flow-endpoint' => array(
                'label'       => __("Payment Flow Endpoint", "enginethemes"),
                'description' => __("Endpoints are appended to your page URLs to handle specific actions on the accounts pages and they should be unique", "enginethemes"),
                'slug'        => 'payment-flow-endpoint',
                'type'        => 'multi_field',
                'name'        => 'user-account-endpoint',
                'data'        => marketengine_get_list_of_page(),
                'template'    => array(
                    'ep-order' => array(
                        'label'       => __("Confirm Order", "enginethemes"),
                        'description' => __("Endpoint for the Confirm Order -> Order id page", "enginethemes"),
                        'slug'        => 'ep-orderid',
                        'type'        => 'textbox',
                        'name'        => 'ep_orderid',
                        'placeholder' => 'order',
                        'template'    => array(),
                    )
                ),
            ),
        ),
    ),
    'other' => array(
        'title'    => __("Other", "enginethemes"),
        'slug'     => 'other',
        'type'     => 'section',
        'template' => array(
            'inquiry-page' => array(
                'label'       => __("Inquiry Page", "enginethemes"),
                'description' => __("Choose a page to display as Inquiry Page", "enginethemes"),
                'slug'        => 'me_inquiry_form',
                'type'        => 'select',
                'name'        => 'me_inquiry_page_id',
                'data'        => marketengine_get_list_of_page(),
            )
        ),
    )
);
