<?php
/**
 * Fields are predefined and user only selected available values. Using wordpress taxonomy to control the field value
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

add_action('init', 'me_cf_register_field_taxonomies');
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

function me_cf_register_field_taxonomy($field)
{
    $labels = array(
        'name'          => $field['field_title'],
        'singular_name' => $field['field_title'],
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => false,
        'show_admin_column' => false,
        'query_var'         => true,
        'rewrite'           => false,
    );
    $args = apply_filters('marketengine_register_field_taxonomy_args', $args, $field);
    register_taxonomy($field['field_name'], 'listing', $args);
}

function me_cf_get_field_options($field_name, $args = array())
{
    $result   = array();
    $defaults = array('hide_empty' => 0);
    $args     = wp_parse_args($args, $defaults);

    $termlist = get_terms($field_name, $args);

    foreach ($termlist as $term) {
        $result[] = array(
            'value' => $term->term_id,
            'label' => $term->name,
            'key'   => $term->slug,
        );
    }

    return $result;
}

// function me_cf_add_field_taxonomy_option()
// {

// }

// dang ky taxonomy, luu y taxonomy se la build-in, ko show trong menu
// luu option tu add field, update field
// get field option tạo format $key : $value ( trong backend )
// get field option format $key => $value (ở front-end)
// ... co the co nhieu ham bo tro nua
