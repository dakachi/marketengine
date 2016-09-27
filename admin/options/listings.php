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
            'listings-page' => array(
                'label'    => __("Listings Page", "enginethemes"),
                'slug'     => 'listings-page',
                'type'     => 'select',
                'data'     => marketengine_get_list_of_page(),
                'template' => array(
                ),
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
);