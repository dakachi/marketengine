<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

return array(
    'general' => array(
        'title'    => __("Authentication", "enginethemes"),
        'slug'     => 'authentication',
        'type'     => 'section',
        'template' => array(
            'haha' => array(
                'label'       => __("Authentication", "enginethemes"),
                'description' => __("The facebook authentication public api key", "enginethemes"),
                'slug'        => 'haha',
                'type'        => 'textbox',
                'template'    => array(),
            ),
            'hihi' => array(
                'label'       => __("Authentication", "enginethemes"),
                'description' => __("The facebook authentication public api key", "enginethemes"),
                'slug'        => 'hihi',
                'type'        => 'textbox',
                'template'    => array(),
            ),
        ),
    ),
);