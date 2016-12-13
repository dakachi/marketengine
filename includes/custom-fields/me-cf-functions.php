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
 * @param array $args Field information
 *             - string field_name Field name should be unique
 *             - string field_title Field Title
 *             - string field_type Field type: text, number, textarea, date, checkbox, radio, multiselect, select
 *             - string field_input_type
 *             - string field_placeholder Field placeholder
 *             - string field_description The field description in listing details
 *             - string field_help_text The field helptext in submit listing form
 *             - string field_constraint Field constraint condition
 *             - string field_default_value Field default value
 *             - int count Field category count
 * @param bool $wp_error
 *
 * @package Includes/CustomField
 * @category Function
 *
 * @return int | WP_Error
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
        'count'               => 0,
    );
    $args = wp_parse_args($args, $defaults);
    // validate data
    // validate field name
    $field_name = $args['field_name'];
    if (!$field_name || !preg_match('/^[a-z0-9_]+$/', $field_name)) {
        if ($wp_error) {
            return new WP_Error('field_name_format_invalid', __("Field name only lowercase letters (a-z, -, _) and numbers are allowed.", 'enginethemes'));
        } else {
            return 0;
        }

    }

    $field_title = $args['field_title'];
    if (empty($field_title)) {
        if ($wp_error) {
            return new WP_Error('field_title_empty', __("Field title can not be empty.", 'enginethemes'));
        } else {
            return 0;
        }
    }

    $field_type = $args['field_type'];
    if (empty($field_type)) {
        if ($wp_error) {
            return new WP_Error('field_type_empty', __("Field type can not be empty.", 'enginethemes'));
        } else {
            return 0;
        }
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
    $count               = $args['count'];

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

/**
 * Update custom field
 *
 * @param array $args Field information
 *             - string field_name
 *             - string field_title
 *             - string field_type
 *             - string field_input_type
 *             - string field_placeholder
 *             - string field_description The field description in listing details
 *             - string field_help_text The field helptext in submit listing form
 *             - string field_constraint Field constraint condition
 *             - string field_default_value Field default value
 *             - int count Field category count
 * @param bool $wp_error
 *
 * @package Includes/CustomField
 * @category Function
 *
 * @return int | WP_Error
 */
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

/**
 * Delete custom field
 *
 * @param int $field_id The delete field id
 *
 * @package Includes/CustomField
 * @category Function
 *
 * @return bool
 */
function me_cf_delete_field($field_id)
{
    global $wpdb;

    $field_table = $wpdb->prefix . 'marketengine_custom_fields';
    // delete field
    $deleted = $wpdb->delete($field_table, array('field_id' => $field_id));
    if (!$deleted) {
        return false;
    }

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
    return $field_id;
}

/**
 * Relates a field to a listing category.
 *
 * @param int $field_id The field id
 * @param int $term_id The category id
 * @param int $order The position field will be list
 *
 * @package Includes/CustomField
 * @category Function
 *
 * @return void
 */
function me_cf_set_field_category($field_id, $term_id, $order)
{
    global $wpdb;

    $field_id = (int) $field_id;
    $term_id  = (int) $term_id;
    if (!term_exists($term_id, 'listing_category')) {
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
    me_cf_update_field_count($field_id);
    me_cf_update_term_count($term_id);
}

/**
 * Un-relates a field to a listing category.
 *
 * @param int $field_id The field id
 * @param int $term_id The category id
 *
 * @package Includes/CustomField
 * @category Function
 *
 * @return void
 */

function me_cf_remove_field_category($field_id, $term_id)
{
    global $wpdb;

    $field_id = (int) $field_id;
    if (!term_exists((int) $term_id, 'listing_category')) {
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
    $term_count = $wpdb->get_var($wpdb->prepare("SELECT count(term_taxonomy_id) FROM $wpdb->marketengine_fields_relationship WHERE field_id = %d", $field_id));

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
    global $wpdb;

    $field = absint($field);
    $sql   = "SELECT *
            FROM $wpdb->marketengine_custom_fields as C
            WHERE C.field_id = {$field}";

    $results = $wpdb->get_row($sql, ARRAY_A);

    return $results;
}

function me_cf_fields_query($args)
{
    global $wpdb;

    $defaults = array(
        'paged'     => 1,
        'showposts' => get_option('posts_per_page'),
    );
    $args = wp_parse_args($args, $defaults);

    $sql = $limit = '';

    $sql = "SELECT SQL_CALC_FOUND_ROWS *
            FROM $wpdb->marketengine_custom_fields as C";

    $current = (absint($args['paged']) - 1) * $args['showposts'];
    $limit   = " LIMIT " . ($current) . ', ' . $args['showposts'];

    $sql .= $limit;

    $results = $wpdb->get_results($sql, ARRAY_A);

    $found_rows     = $wpdb->get_var('SELECT FOUND_ROWS() as row');
    $max_numb_pages = ceil($found_rows / $args['showposts']);

    return array(
        'fields'         => $results,
        'found_posts'    => $found_rows,
        'max_numb_pages' => $max_numb_pages,
    );
}

function me_cf_get_fields($category_id)
{
    global $wpdb;
    $sql = $join = $where = '';
    $sql = "SELECT *
            FROM $wpdb->marketengine_custom_fields as C";
    if ($category_id) {
        $join = " LEFT JOIN $wpdb->marketengine_fields_relationship as R
                    ON C.field_id = R.field_id";
        $where = " WHERE R.term_taxonomy_id = {$category_id}";
    }
    $sql .= $join . $where;
    $results = $wpdb->get_results($sql, ARRAY_A);

    return $results;
}

function me_cf_get_fields_by_category($category_id)
{
    global $wpdb;

    $sql = $join = $where = '';

    $sql = "SELECT *
            FROM $wpdb->marketengine_custom_fields as C";
    $join = " LEFT JOIN $wpdb->marketengine_fields_relationship as R
                    ON C.field_id = R.field_id";
    $where = " WHERE R.term_taxonomy_id = {$category_id}";

    $sql .= $join . $where;

    $results = $wpdb->get_results($sql, ARRAY_A);

    return $results;
}

function me_cf_get_affected_categories($field_id)
{
    global $wpdb;

    $sql   = "SELECT DISTINCT R.term_taxonomy_id";
    $from  = " FROM $wpdb->marketengine_fields_relationship as R";
    $where = " WHERE R.field_id = $field_id";

    $sql .= $from . $where;

    $results = $wpdb->get_col($sql);

    return $results;
}

function me_cf_get_affected_categories_html($field_id)
{
    $affected_cats      = me_cf_get_affected_categories($field_id);
    $affected_cats_name = '';
    foreach ($affected_cats as $key => $cat) {
        $cat_name = get_term($cat)->name;
        $affected_cats_name .= $cat_name . ', ';
    }
    return $affected_cats_name;
}

function me_field($field_name, $post = null, $single = true)
{
    if (!$post) {
        $post = get_post();
    }
    return get_post_meta($post->ID, $field_name, $single);
}

function me_get_the_field($field_id)
{
    global $wpdb;

    $sql  = "SELECT *";
    $from = " FROM $wpdb->marketengine_custom_fields as C";
    $join = " LEFT JOIN $wpdb->marketengine_fields_relationship as R
                    ON C.field_id = R.field_id";
    $where = " WHERE C.field_id = {$field_id}";

    $sql .= $from . $join . $where;

    $results = $wpdb->get_row($sql, ARRAY_A);

    return $results;
}

function me_the_field($field_name, $post = null, $single = true)
{
    if (!$post) {
        $post = get_post();
    }
    echo get_post_meta($post->ID, $field_name, $single);
}

function me_field_attribute($field)
{
    $constraint = explode('|', $field['field_constraint']);
    if (empty($constraint)) {
        return '';
    }

    $attr = '';

    foreach ($constraint as $value) {
        if ($value == 'required') {
            $attr .= 'required="true" ';
        }

        if (strpos($value, 'min') !== false || strpos($value, 'max') !== false) {
            $min = explode(':', $value);
            $attr .= $min[0] . '="' . $min[1] . '" ';
        }
    }
    return apply_filters('marketengine_cf_field_attribute', $attr, $field);
}

function me_custom_field_page_url($view = '', $action = '')
{
    $url = add_query_arg('section', 'custom-field', me_menu_page_url('me-settings', 'marketplace-settings'));

    $url = $view ? add_query_arg('view', $view, $url) : $url;
    $url = $action ? add_query_arg('action', $action, $url) : $url;

    return $url;
}
