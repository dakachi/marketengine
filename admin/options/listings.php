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
            'post-listings-page' => array(
                'label'         => __("Post Listing Page", "enginethemes"),
                'description'   => '',
                'slug'          => 'me_post_listing_form',
                'name'          => 'me_post_listing_page_id',
                'type'          => 'select',
                'data'          => marketengine_get_list_of_page(),
                'template'      => array(),
            ),
            'listings-page' => array(
                'label'         => __("Listings Page", "enginethemes"),
                'description'   => '',
                'slug'          => 'me_listings',
                'name'          => 'me_listings_page_id',
                'type'          => 'select',
                'data'          => marketengine_get_list_of_page(),
                'template'      => array(),
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