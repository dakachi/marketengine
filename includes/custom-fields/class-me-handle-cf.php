<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Class ME Handle CF
 * Handle MarketEngine Custom Field in post, edit listing form and listing details
 *
 * @package Includes/CustomFields
 * @category Class
 *
 * @version 1.0
 * @since 1.0.1
 */
class ME_Handle_CF
{
    public function __construct()
    {
        // render field form in post, edit listing
        add_action('marketengine_edit_listing_information_form_fields', array($this, 'edit_form_fields'));
        add_action('marketengine_post_listing_information_form_fields', array($this, 'post_form_fields'));

        // add ajax load custom field when user select category
        add_action('wp_ajax_me-load-category-fields', array($this, 'load_category_fields'));

        add_action('marketengine_after_update_listing', array($this, 'update_fields'), 10, 2);
        add_action('marketengine_after_insert_listing', array($this, 'update_fields'), 10, 2);

        // custom field in listing details
        add_action('marketengine_after_single_listing_details', array($this, 'field_details'));
    }

    public function edit_form_fields($listing)
    {
        $category = wp_get_object_terms($listing->ID, 'listing_category', array('parent' => 0, 'fields' => 'ids'));
        if (empty($category)) {
            return;
        }

        $fields = me_cf_get_fields($category[0]);
        me_get_template('custom-fields/edit-field-form', array('fields' => $fields, 'listing' => $listing));
    }

    public function post_form_fields()
    {
        me_get_template('custom-fields/post-field-form');
    }

    public function load_category_fields()
    {
        if (empty($_GET['cat'])) {
            exit;
        }

        $cat    = $_GET['cat'];
        $fields = me_cf_get_fields($cat);
        if (empty($fields)) {
            exit;
        }

        foreach ($fields as $field):
            $value = '';
            me_get_template('custom-fields/field-' . $field['field_type'], array('field' => $field, 'value' => $value));
        endforeach;

        exit;
    }

    public function update_fields($post, $data)
    {
        $category = wp_get_object_terms($post, 'listing_category', array('parent' => 0, 'fields' => 'ids'));
        if (empty($category)) {
            return false;
        }

        $fields = me_cf_get_fields($category[0]);
        if (empty($fields)) {
            return false;
        }

        foreach ($fields as $field) {
            $field_name = $field['field_name'];
            if (!empty($data[$field_name])) {
                update_post_meta($post, $field_name, $data[$field_name]);
            }
        }

    }

    public function field_details()
    {
        $post     = get_post();
        $category = wp_get_object_terms($post->ID, 'listing_category', array('parent' => 0, 'fields' => 'ids'));
        if (empty($category)) {
            return;
        }

        $fields = me_cf_get_fields($category[0]);
        me_get_template('custom-fields/field-details', array('fields' => $fields));
    }
}
new ME_Handle_CF();
