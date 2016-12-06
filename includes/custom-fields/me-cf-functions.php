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

function me_cf_insert_field($args, $wp_error = false)
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
    if (!empty($args['field_id'])) {
        $update   = true;
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

    return $field_ID;
}

function me_cf_update_field($args)
{

}

function me_cf_delete_field($args)
{

}

function me_cf_set_field_category($field_id, $term_id, $order)
{
    global $wpdb;

    $object_id = (int) $object_id;

    if (!term_exists($term_id, 'listing_category')) {
        return new WP_Error('invalid_taxonomy', __('Invalid category.', 'enginethemes'));
    }

    $term_info = get_term($term_id, 'listing_category', ARRAY_A);

    $tt_id = $term_info['term_taxonomy_id'];

    if ($wpdb->get_var($wpdb->prepare("SELECT term_taxonomy_id FROM $wpdb->marketengine_custom_fields WHERE object_id = %d AND term_taxonomy_id = %d", $object_id, $tt_id))) {
        // update relationship order
        $wpdb->update($wpdb->marketengine_custom_fields, array('object_id' => $object_id, 'term_taxonomy_id' => $tt_id, 'term_order' => $order));
    } else {
    	// insert relationship
        $wpdb->insert($wpdb->marketengine_custom_fields, array('object_id' => $object_id, 'term_taxonomy_id' => $tt_id, 'term_order' => $order));

    }

    //TODO:
    // me_cf_update_field_count();
    // me_cf_update_term_count();

}

function me_cf_sort_fields($args)
{

}

function me_cf_get_field()
{

}

function me_cf_get_fields($category_id)
{
	return array(
		array(
			'name' => "field_1",
			'title' => "Field 1 in category " . $category_id,
			'type' => 'text',
			'placeholder' => 'field placeholder',
			'description' => 'field description',
			'constraint' => 'required',
			'default_value' => 'field default value',
			'help_text' => 'help text'
		),

		array(
			'name' => "field_2",
			'title' => "Field 2 in category " . $category_id,
			'type' => 'date',
			'placeholder' => 'field placeholder',
			'description' => 'field description',
			'constraint' => 'required',
			'default_value' => 'field default value',
			'help_text' => 'help text'
		),

		array(
			'name' => "field_3",
			'title' => "Field 3 in category " . $category_id,
			'type' => 'number',
			'placeholder' => 'field placeholder',
			'description' => 'field description',
			'constraint' => 'required',
			'default_value' => 'field default value',
			'help_text' => 'help text'
		)
	);
}

function me_field()
{

}

function me_the_field()
{

}
