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

/**
 * Insert custom field
 *
 * @param array $args
 * @param bool $wp_error
 *
 * @package Includes/CustomField
 * @category Function
 */
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
        'count' => 0
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
    if (empty($field_type)) {
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
    $count = $args['count'];

    // save field
    $data = compact('field_name', 'field_title', 'field_type', 'field_input_type', 'field_placeholder', 'field_description', 'field_help_text', 'field_constraint', 'field_default_value', 'count');
    $data = wp_unslash($data);

    $field_table = $wpdb->prefix . 'marketengine_custom_fields';
    if ($update) {
        $where = array('field_id' => $field_ID);
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

    return $field_ID;
}

function me_cf_update_field($args, $wp_error = false)
{
    $field = me_cf_get_field($args['field_id'], ARRAY_A);
    if (is_null($field)) {
        if ($wp_error) {
            return new WP_Error('invalid_field', __('Invalid field ID.'));
        }

        return 0;
    }

    $field = wp_slash($field);
    $args  = array_merge($field, $args);

    return me_cf_insert_field($args, $wp_error);
}

function me_cf_delete_field($field_id)
{
    global $wpdb;

    $field_table = $wpdb->prefix . 'marketengine_custom_fields';
    // delete field
    $wpdb->delete($field_table, array('field_id' => $field_id));
    // delete field relationship
    $tt_ids = $wpdb->get_results($wpdb->prepare("SELECT term_taxonomy_id FROM $wpdb->marketengine_fields_relationship WHERE field_id = %d", $field_id));
    $wpdb->delete($wpdb->marketengine_fields_relationship, array('field_id' => $field_id), array('%d'));
    // update term count
    foreach ($tt_ids as $key => $tt_id) {
        $term = get_term_by('term_taxonomy_id', $tt_id, 'listing_category');
        if (!$term || is_wp_error($term)) {
            continue;
        }

        me_cf_update_term_count($term->term_id);
    }
}

function me_cf_set_field_category($field_id, $term_id, $order)
{
    global $wpdb;

    $field_id = (int) $field_id;
    if (!term_exists((int)$term_id, 'listing_category')) {
        return new WP_Error('invalid_taxonomy', __('Invalid category.', 'enginethemes'));
    }

    $term_info = get_term($term_id, 'listing_category', ARRAY_A);
    $tt_id     = $term_info['term_taxonomy_id'];

    if ($wpdb->get_var($wpdb->prepare("SELECT term_taxonomy_id FROM $wpdb->marketengine_fields_relationship WHERE field_id = %d AND term_taxonomy_id = %d", $field_id, $tt_id))) {
        // update relationship order
        $wpdb->update(
            $wpdb->marketengine_fields_relationship,
            array('term_order' => $order),
            array('field_id' => $field_id, 'term_taxonomy_id' => $tt_id)
        );

    } else {
        // insert relationship
        $wpdb->insert($wpdb->marketengine_fields_relationship, array('field_id' => $field_id, 'term_taxonomy_id' => $tt_id, 'term_order' => $order));
    }

    //TODO:
    me_cf_update_field_count($field_id);
    me_cf_update_term_count($term_id);

}

function me_cf_remove_field_category($field_id, $term_id)
{
	global $wpdb;

    $field_id = (int) $field_id;
    if (!term_exists($term_id, 'listing_category')) {
        return new WP_Error('invalid_taxonomy', __('Invalid category.', 'enginethemes'));
    }

    $term_info = get_term($term_id, 'listing_category', ARRAY_A);
    $tt_id     = $term_info['term_taxonomy_id'];

    $wpdb->delete($wpdb->marketengine_fields_relationship, array('field_id' => $field_id, 'term_taxonomy_id' => $tt_id), array('%d', '%d'));

    me_cf_update_field_count($field_id);
    me_cf_update_term_count($term_id);
}


function me_cf_update_field_count($field_id)
{
    global $wpdb;
    $term_count = $wpdb->get_results($wpdb->prepare("SELECT count(term_taxonomy_id) FROM $wpdb->marketengine_fields_relationship WHERE field_id = %d", $field_id));
    me_cf_update_field(array('field_id' => $field_id, 'count' => $term_count));
}

function me_cf_update_term_count($term_id)
{
    global $wpdb;

    if (!term_exists($term_id, 'listing_category')) {
        return new WP_Error('invalid_taxonomy', __('Invalid category.', 'enginethemes'));
    }

    $term_info = get_term($term_id, 'listing_category', ARRAY_A);
    $tt_id     = $term_info['term_taxonomy_id'];

    $field_count = $wpdb->get_results($wpdb->prepare("SELECT count(field_id) FROM $wpdb->marketengine_fields_relationship WHERE term_taxonomy_id  = %d", $tt_id));
    update_term_meta($term_id, '_me_cf_count', $field_count);

    return $field_count;
}


function me_cf_get_field($field, $type = OBJECT)
{
    // return array(
    //     'field_name'          => "field_1",
    //     'field_title'         => "Field 1 in category ",
    //     'field_type'          => 'text',
    //     'field_placeholder'   => 'field placeholder',
    //     'field_description'   => 'field description',
    //     'field_constraint'    => 'required',
    //     'field_default_value' => 'field default value',
    //     'field_help_text'     => 'help text',
    // );
    global $wpdb;

    $sql = "SELECT *
            FROM $wpdb->marketengine_custom_fields as C
            LEFT JOIN $wpdb->marketengine_fields_relationship as R
            ON C.field_id = R.field_id
            WHERE C.field_id = {$field}";

    $results = $wpdb->get_results($sql);

    if($type != OBJECT) {
        $results = apply_filters('me_filter_cf_get_fields', $results)[0];
    }

    return $results;
}

function me_cf_get_fields($category_id = '')
{
    global $wpdb;

    $sql = $join = $where = '';

    $sql = "SELECT *
            FROM $wpdb->marketengine_custom_fields as C";

    if($category_id) {
        $join = " LEFT JOIN $wpdb->marketengine_fields_relationship as R
                    ON C.field_id = R.field_id";
        $where = " WHERE R.term_taxonomy_id = {$category_id}";
    }

    $sql .= $join . $where;

    $results = $wpdb->get_results($sql);

    $results = apply_filters('me_filter_cf_get_fields', $results);

    return $results;
    // return array(
    //     array(
    //         'field_name'          => "field_1",
    //         'field_title'         => "Field 1 in category " . $category_id,
    //         'field_type'          => 'text',
    //         'field_placeholder'   => 'field placeholder',
    //         'field_description'   => 'field description',
    //         'field_constraint'    => 'required',
    //         'field_default_value' => 'field default value',
    //         'field_help_text'     => 'help text',
    //     ),

    //     array(
    //         'field_name'          => "field_2",
    //         'field_title'         => "Field 2 in category " . $category_id,
    //         'field_type'          => 'date',
    //         'field_placeholder'   => 'field placeholder',
    //         'field_description'   => 'field description',
    //         'field_constraint'    => 'required',
    //         'field_default_value' => 'field default value',
    //         'field_help_text'     => 'help text',
    //     ),

    //     array(
    //         'field_name'          => "field_3",
    //         'field_title'         => "Field 3 in category " . $category_id,
    //         'field_type'          => 'number',
    //         'field_placeholder'   => 'field placeholder',
    //         'field_description'   => 'field description',
    //         'field_constraint'    => 'required',
    //         'field_default_value' => 'field default value',
    //         'field_help_text'     => 'help text',
    //     ),
    //     array(
    //         'field_name'          => "field_4",
    //         'field_title'         => "Field 3 in category " . $category_id,
    //         'field_type'          => 'textarea',
    //         'field_placeholder'   => 'field placeholder',
    //         'field_description'   => 'field description',
    //         'field_constraint'    => 'required',
    //         'field_default_value' => 'field default value',
    //         'field_help_text'     => 'help text',
    //     ),
    //     array(
    //         'field_name'          => "field_4",
    //         'field_title'         => "Field 3 in category " . $category_id,
    //         'field_type'          => 'checkbox',
    //         'field_placeholder'   => 'field placeholder',
    //         'field_description'   => 'field description',
    //         'field_constraint'    => 'required',
    //         'field_default_value' => 'field default value',
    //         'field_help_text'     => 'help text',
    //     ),
    // );
}

function marketengine_filter_cf_get_fields($field_objs) {
    $field_arr = array();
    foreach( $field_objs as $key => $field_obj ) {
        $field_arr[] =  array(
            'field_name'          => $field_obj->field_name,
            'field_title'         => $field_obj->field_title,
            'field_type'          => $field_obj->field_type,
            'field_placeholder'   => isset($field_obj->field_placeholder) ? $field_obj->field_placeholder : '',
            'field_description'   => isset($field_obj->field_description) ? $field_obj->field_description : '',
            'field_constraint'    => $field_obj->field_constraint ? 'required' : '',
            'field_default_value' => isset($field_obj->field_default_value) ? $field_obj->field_default_value : '',
            'field_help_text'     => isset($field_obj->field_help_text) ? $field_obj->field_help_text : '',
            'count'         => $field_obj->count,
        );
    }
    return $field_arr;
}
add_filter('me_filter_cf_get_fields', 'marketengine_filter_cf_get_fields');

function me_field($field_name, $post = null, $single = true)
{
    if (!$post) {
        $post = get_post();
    }
    return get_post_meta($post->ID, $field_name, $single);
}

function me_the_field($field_name, $post = null, $single = true)
{
	if (!$post) {
        $post = get_post();
    }
    echo get_post_meta($post->ID, $field_name, $single);
}

function me_custom_field_page_url( $view = '', $action = '') {
    $url = add_query_arg('section', 'custom-field', me_menu_page_url('me-settings', 'marketplace-settings'));

    $url = $view ? add_query_arg('view', $view , $url) : $url;
    $url = $action ? add_query_arg('action', $action , $url) : $url;

    return $url;
}