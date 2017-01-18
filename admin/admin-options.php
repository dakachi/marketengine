<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
// section
return array(
    'title' => esc_html(__('General', 'jobplanet-plugin')),
    'name'  => 'general_option',
    'icon'  => 'font-awesome:fa-dot-circle-o',
    'menus' => array(
        array(
            'title'    => esc_html(__('Logo', 'jobplanet-plugin')),
            'name'     => 'logo_setting',
            'icon'     => 'font-awesome:fa-image',
            'controls' => array(
                array(
                    'type'        => 'upload',
                    'name'        => 'logo',
                    'label'       => esc_html(__('Logo', 'jobplanet-plugin')),
                    'description' => esc_html(__('Upload image for Logo', 'jobplanet-plugin')),
                    'default'     => get_template_directory_uri() . '/assets/theme/images/logo.png',
                ),
                array(
                    'type'        => 'upload',
                    'name'        => 'logo_retina',
                    'label'       => esc_html(__('Logo for Retina Displays', 'jobplanet-plugin')),
                    'description' => esc_html(__('Upload image for Retina Display version of your Logo', 'jobplanet-plugin')),
                    'default'     => get_template_directory_uri() . '/assets/theme/images/logo.png',
                ),

                array(
                    'type'        => 'upload',
                    'name'        => 'logo_mobile',
                    'label'       => esc_html(__('Mobile Logo', 'jobplanet-plugin')),
                    'description' => esc_html(__('Upload Image for the Mobile version of your Logo', 'jobplanet-plugin')),
                    'default'     => get_template_directory_uri() . '/assets/theme/images/logo.png',
                ),
                array(
                    'type'        => 'upload',
                    'name'        => 'logo_mobile_retina',
                    'label'       => esc_html(__('Logo for Mobile Retina Displays', 'jobplanet-plugin')),
                    'description' => esc_html(__('Upload Image for Mobile Retina Displays version of your Logo', 'jobplanet-plugin')),
                    'default'     => get_template_directory_uri() . '/assets/theme/images/logo.png',
                ),

            ),
        )

    )
);