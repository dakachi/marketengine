<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

return array(
    'general' => array(
        'title'    => __("General", "enginethemes"),
        'slug'     => 'general',
        'type'     => 'section',
        'template' => array(
            'ep-forgot-password' => array(
                'label'       => __("Forgot Password", "enginethemes"),
                'slug'        => 'ep-forgot-password',
                'type'        => 'textbox',
                'name'        => 'ep_forgot_password',
                'placeholder' => 'forgot-password',
                'template'    => array(),
            ),
            'ep-reset-password' => array(
                'label'       => __("Reset Password", "enginethemes"),
                'slug'        => 'ep-reset-password',
                'type'        => 'textbox',
                'name'        => 'ep_reset_password',
                'placeholder' => 'reset-password',
                'template'    => array(),
            ),
            'ep-register' => array(
                'label'       => __("Register", "enginethemes"),
                'slug'        => 'ep-register',
                'type'        => 'textbox',
                'name'        => 'ep_register',
                'placeholder' => 'register',
                'template'    => array(),
            ),
            'ep-listings' => array(
                'label'       => __("Listings", "enginethemes"),
                'slug'        => 'ep-listings',
                'type'        => 'textbox',
                'name'        => 'ep_listings',
                'placeholder' => 'listings',
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
    'user-account' => array(
        'title'    => __("User Account", "enginethemes"),
        'slug'     => 'user-account',
        'type'     => 'section',
        'template' => array(
            'ep-edit-profile' => array(
                'label'       => __("Edit Profile", "enginethemes"),
                'slug'        => 'ep-edit-profile',
                'type'        => 'textbox',
                'name'        => 'ep_edit_profile',
                'placeholder' => 'edit-profile',
                'template'    => array(),
            ),
            'ep-change-password' => array(
                'label'       => __("Change Password", "enginethemes"),
                'slug'        => 'ep-change-password',
                'type'        => 'textbox',
                'name'        => 'ep_change_password',
                'placeholder' => 'change-password',
                'template'    => array(),
            ),
            'ep-orders' => array(
                'label'       => __("Orders", "enginethemes"),
                'slug'        => 'ep-orders',
                'type'        => 'textbox',
                'name'        => 'ep_orders',
                'placeholder' => 'orders',
                'template'    => array(),
            ),
            'ep-order' => array(
                'label'       => __("Order", "enginethemes"),
                'slug'        => 'ep-order',
                'type'        => 'textbox',
                'name'        => 'ep_order',
                'placeholder' => 'order',
                'template'    => array(),
            ),
            'ep-orders' => array(
                'label'       => __("Orders", "enginethemes"),
                'slug'        => 'ep-orders',
                'type'        => 'textbox',
                'name'        => 'ep_orders',
                'placeholder' => 'orders',
                'template'    => array(),
            ),
            'ep-order' => array(
                'label'       => __("Order", "enginethemes"),
                'slug'        => 'ep-order',
                'type'        => 'textbox',
                'name'        => 'ep_order',
                'placeholder' => 'order',
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
    'checkout' => array(
        'title'    => __("Checkout", "enginethemes"),
        'slug'     => 'checkout',
        'type'     => 'section',
        'template' => array(
        ),
    ),
);