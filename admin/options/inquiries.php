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
            'inquiry-page' => array(
                'label'       => __("Inquiry Page", "enginethemes"),
                'description' => __("Choose a page to display as Inquiry Page", "enginethemes"),
                'slug'        => 'me_inquiry_form',
                'type'        => 'select',
                'name'        => 'me_inquiry_page_id',
                'data'        => marketengine_get_list_of_page(),
                'template'    => array(),
            )
        ),
    )
);