<?php
/**
 * Fields are predefined and user only selected available values. Using wordpress taxonomy to control the field value
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register taxonomy to control custom field value for checkbox, multi-select, single-select
 *
 * @package Includes/CustomField
 * @category Function
 *
 * @since 1.0.1
 */
function me_cf_register_field_taxonomies()
{
    // get fields by type select, checkbox, multiselect, radio
    $fields_query = me_cf_fields_query(array('showposts' => -1, 'field_type' => array('single-select', 'multi-select', 'radio', 'checkbox')));
    $fields       = $fields_query['fields'];
    if (empty($fields)) {
        return;
    }

    foreach ($fields as $field) {
        // register taxonomy
        me_cf_register_field_taxonomy($field);
    }
}
add_action('init', 'me_cf_register_field_taxonomies');

/**
 * Register taxonomy to control a field value
 * 
 * @param array $field The field data
 * @see register_taxonomy()
 *
 * @package Includes/CustomField
 * @category Function
 *
 * @since 1.0.1
 */
function me_cf_register_field_taxonomy($field)
{
    $labels = array(
        'name'          => $field['field_title'],
        'singular_name' => $field['field_title'],
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => false,
    );
    $args = apply_filters('marketengine_register_field_taxonomy_args', $args, $field);
    register_taxonomy($field['field_name'], 'listing', $args);
}

/**
 * 
 */
function me_cf_get_field_options($field_name, $args = array())
{
    $results   = array();
    $defaults = array('hide_empty' => 0);
    // order by meta key _field_option_order
    $args     = wp_parse_args($args, $defaults);

    $termlist = get_terms($field_name, $args);

    foreach ($termlist as $term) {
        $results[$term->slug] = array(
            'value' => $term->term_id,
            'label' => $term->name,
            'key'   => $term->slug,
        );
    }

    return $results;
}
