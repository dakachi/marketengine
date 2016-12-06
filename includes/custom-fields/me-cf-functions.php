<?php
/**
 * Related to Listing Custom Fields Functions
 * @package Includes/CustomField
 * @category Function
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function me_insert_field($args)
{
    global $wpdb;
    $defaults = array(
        'field_name'          => '',
        'field_title'         => '',
        'field_type'          => '',
        'field_input_type'    => 'string',
        'field_placeholder'   => '',
        'field_description'   => '',
        'field_help_text'     => '',
        'field_constraint'    => '',
        'field_default_value' => '',
    );
    $args = wp_parse_args($args, $defaults);
    // validate data
    // validate field name
    $field_name = $args['field_name'];
    if (!$field_name || !preg_match('/^[a-z0-9_]+$/', $field_name)) {
        return new WP_Error('field_name_format_invalid', __("Field name only lowercase letters (a-z, -, _) and numbers are allowed.", 'enginethemes'));
    }

    $field_title = $args['field_title'];
    if (empty($field_title)) {
        return new WP_Error('field_title_empty', __("Field title can not be empty.", 'enginethemes'));
    }

    $field_type = $args['field_type'];
    if (empty($field_title)) {
        return new WP_Error('field_type_empty', __("Field type can not be empty.", 'enginethemes'));
    }

    $update = false;
    if(!empty($args['field_id'])) {
    	$update = true;
    	$field_ID = $args['field_id'];
    }

    $field_placeholder   = $args['field_placeholder'];
    $field_description   = $args['field_description'];
    $field_input_type    = $args['field_input_type'];
    $field_constraint    = $args['field_constraint'];
    $field_help_text     = $args['field_help_text'];
    $field_default_value = $args['field_default_value'];

    // save field
    $data = compact('field_name', 'field_title', 'field_type', 'field_input_type', 'field_placeholder', 'field_description', 'field_help_text', 'field_constraint', 'field_default_value');
    $data = wp_unslash($data);

    $field_table = $wpdb->prefix . 'marketengine_custom_fields';
    if ($update) {
        /**
         * Fires immediately before an existing post is updated in the database.
         *
         * @since 1.0.0
         *
         * @param int   $field_ID Field ID.
         * @param array $data    Array of unslashed post data.
         */
        do_action('pre_field_update', $field_ID, $data);
        if (false === $wpdb->update($field_table, $data, $where)) {
            if ($wp_error) {
                return new WP_Error('db_update_error', __('Could not update field in the database', 'enginethemes'), $wpdb->last_error);
            } else {
                return 0;
            }
        }
    } else {
        // If there is a suggested ID, use it if not already present.
        if (!empty($import_id)) {
            $import_id = (int) $import_id;
            if (!$wpdb->get_var($wpdb->prepare("SELECT ID FROM $field_table WHERE ID = %d", $import_id))) {
                $data['ID'] = $import_id;
            }
        }
        if (false === $wpdb->insert($field_table, $data)) {
            if ($wp_error) {
                return new WP_Error('db_insert_error', __('Could not insert field into the database', 'enginethemes'), $wpdb->last_error);
            } else {
                return 0;
            }
        }
        $field_ID = (int) $wpdb->insert_id;

        // Use the newly generated $field_ID.
        $where = array('ID' => $field_ID);
    }

    // set field and category relationship, order
}

function me_update_field($args)
{

}

function me_delete_field($args)
{

}

function me_sort_fields($args)
{

}

function me_get_field()
{

}

function me_get_fields()
{

}

function me_field()
{

}

function me_the_field()
{

}
