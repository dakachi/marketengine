<?php
/**
 * ME Custom field options array template
 * @since 1.0.1
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

return apply_filters('marketengine_custom_field_options',
    array(
        'add-new-cf' => array(
            'title'       => __("Add New Custom Field", "enginethemes"),
            'wrapper'     => "h2",
            'type'        => 'section_title',
            'template'    => array(),
        ),
        'field-name' => array(
            'label'       => __("Field Name", "enginethemes"),
            'description' => __("", "enginethemes"),
            'slug'        => 'field-name',
            'type'        => 'textbox',
            'name'        => 'field-name',
            'template'    => array(),
        ),
        'field-title' => array(
            'label'       => __("Field Title", "enginethemes"),
            'description' => __("", "enginethemes"),
            'slug'        => 'field-title',
            'type'        => 'textbox',
            'name'        => 'field-title',
            'template'    => array(),
        ),
        'field-type' => array(
            'label'       => __("Field Type", "enginethemes"),
            'description' => __("", "enginethemes"),
            'slug'        => 'field-type',
            'type'        => 'select_group',
            'placeholder' => __("Choose field type", "enginethemes"),
            'data'        => me_list_custom_field_type(),
            'name'        => 'field-type',
            'template'    => array(),
        ),
        'field-required' => array(
            'label'       => __("Required?", "enginethemes"),
            'description' => __("", "enginethemes"),
            'slug'        => 'field-required',
            'type'        => 'radio',
            'data'        => array(
                'yes'   => 'Yes',
                'no'    => 'No',
            ),
            'name'        => 'field-required',
            'template'    => array(),
        ),
        'field-available' => array(
            'label'       => __("Available In Which Categories", "enginethemes"),
            'description' => __("", "enginethemes"),
            'slug'        => 'field-available',
            'type'        => 'multiselect',
            'data'        => me_get_listing_categories(),
            'name'        => 'field-available',
            'template'    => array(),
        ),
        'help-text' => array(
            'label'       => __("Help text (optional)", "enginethemes"),
            'description' => __("Help text for fields of post listing form", "enginethemes"),
            'slug'        => 'help-text',
            'type'        => 'textarea',
            'name'        => 'help-text',
            'template'    => array(),
        ),
        'field-description' => array(
            'label'       => __("Description (optional)", "enginethemes"),
            'description' => __("", "enginethemes"),
            'slug'        => 'field-description',
            'type'        => 'textarea',
            'name'        => 'field-description',
            'template'    => array(),
        ),
        'field-submit' => array(
            'label'       => __("Save", "enginethemes"),
            'description' => __("", "enginethemes"),
            'slug'        => 'field-submit',
            'type'        => 'button',
            'name'        => 'field-submit',
            'class'       => 'me-cf-save-btn',
            'template'    => array(
                'field-cancel' => array(
                    'label'       => __("Cancel", "enginethemes"),
                    'description' => __("", "enginethemes"),
                    'slug'        => 'field-cancel',
                    'type'        => 'link',
                    'name'        => 'field-cancel',
                    'class'       => 'me-cf-cancel-btn',
                    'template'    => array(),
                ),
            ),
        ),
    )
);