<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Listing_Handle {
    /**
     * Insert Listing
     *
     * Insert Listing to database
     *
     * @since 1.0
     *
     * @see wp_insert_post()
     * @param array $listing_data
     *
     * @return WP_Error| WP_Post
     */
    public static function insert($listing_data) {
        global $user_ID;
        // validate data
        $is_valid = self::validate($listing_data);
        if (is_wp_error($is_valid)) {
            return $is_valid;
        }

        $listing_data = self::filter($listing_data);

        if (isset($listing_data['ID'])) {
            if (($listing_data['post_author'] != $user_ID) && !current_user_can('edit_others_posts')) {
                return new WP_Error('edit_others_posts', __("You are not allowed to edit posts as this user.", "enginethemes"));
            }
            $post = wp_update_post($listing_data);
        } else {
            if (!self::current_user_can_create_listing()) {
                return new WP_Error('create_posts', __("You are not allowed to create posts as this user.", "enginethemes"));
            }
            $post = wp_insert_post($listing_data);
        }
        return $post;
    }

    /**
     * Update Listing
     *
     * Update Listing Data to database
     *
     * @since 1.0
     *
     * @see insert()
     * @param array $listing_data
     *
     * @return WP_Error| WP_Post
     */
    public static function update($listing_data) {
        return self::insert($listing_data);
    }

    /**
     * Filter Listing Data
     *
     * Convert the listing data to compatible with wordpress post data
     *
     * @since 1.0
     *
     * @param array $listing_data
     *
     * @return array The listing data filtered
     */
    public static function filter($listing_data) {
        $listing_data['post_type'] = 'listing';
        
        $listing_data['post_title'] = $listing_data['listing_title'];
        $listing_data['post_content'] = $listing_data['listing_content'];
        // filter taxonomy
        $listing_data['tax_input']['listing_category'] = array($listing_data['parent_cat'], $listing_data['sub_cat']);
        $listing_data['tax_input']['listing_tag'] = $listing_data['listing_tag'];

        // set listing status
        if(self::current_user_can_publish_listing()) {
            $listing_data['post_status'] = 'publish';
        }
        /**
         * Filter listing data 
         *
         * @param array $listing_data
         * @since 1.0
         */
        return apply_filters('marketengine_filter_listing_data', $listing_data);
    }

    /**
     * Check current user create post capability
     *
     * @since 1.0
     *
     * @return bool
     */
    public static function current_user_can_create_listing() {
        global $user_ID;
        return apply_filters('marketengine_user_can_create_listing', true, $user_ID);
    }

    /**
     * Check current user create publish post capability
     *
     * @since 1.0
     *
     * @return bool
     */
    public static function current_user_can_publish_listing() {
        global $user_ID;
        return apply_filters('marketengine_user_can_publish_listing', true, $user_ID);
    }

    /**
     * Check current user create new term taxonomy
     *
     * @since 1.0
     *
     * @return bool
     */
    public static function current_user_can_create_taxonomy($taxonomy) {
        global $user_ID;
        if (is_taxonomy_hierarchical($taxonomy)) {
            return apply_filters('marketengine_user_can_create_$taxonomy', false, $taxonomy, $user_ID);
        }
        return apply_filters('marketengine_user_can_create_$taxonomy', true, $taxonomy, $user_ID);
    }
    /**
     * Validate listing data
     *
     * Validate listing data, listing meta data, listing taxonomy data
     *
     * @since 1.0
     *
     * @see me_validate
     * @param array $data Listing data
     *
     * @return True|WP_Error True if success, WP_Error if false
     *
     */
    public static function validate($listing_data) {
        $invalid_data = array();
        // validate post data
        $rules = array(
            'listing_title' => 'required',
            'listing_content' => 'required',
            'listing_type' => 'required|in:contact,purchasion,rental',
        );
        /**
         * Filter listing data validate rule
         *
         * @param array $rules
         * @param array $listing_data
         * @since 1.0
         */
        $rules = apply_filters('marketengine_insert_listing_rules', $rules, $listing_data);
        $is_valid = me_validate($listing_data, $rules);
        if (!$is_valid) {
            $invalid_data = me_get_invalid_message($listing_data, $rules);
        }
        /**
         * Filter listing meta data validate rule
         *
         * @param array $listing_meta_data_rules
         *
         * @since 1.0
         */
        $listing_meta_data_rules = apply_filters('marketengine_insert_listing_meta_rules', array('listing_price' => 'numeric'));
        // validate post meta data
        $is_valid = me_validate($listing_data['meta_input'], $listing_meta_data_rules);
        if (!$is_valid) {
            $invalid_data = array_merge($invalid_data, me_get_invalid_message($listing_data['meta_input'], $listing_meta_data_rules));
        }

        // validate listing category
        if (empty($listing_data['parent_cat'])) {
            $invalid_data['listing_category'] = __("The listing category field is required.", "enginethemes");
        } elseif (!term_exists(intval($listing_data['parent_cat']), 'listing_category')) {
            $invalid_data['invalid_listing_category'] = __("The selected listing category is invalid.", "enginethemes");
        } else {
            // check the parent cat sub is empty or not
            $child_cats = get_terms('listing_category', array('hide_empty' => false, 'parent' => $listing_data['parent_cat']));
            $is_child_cats_empty = empty($child_cats);
            // validate sub cat
            if (!$is_child_cats_empty && empty($listing_data['sub_cat'])) {
                $invalid_data['sub_listing_category'] = __("The sub listing category field is required.", "enginethemes");
            } elseif (!$is_child_cats_empty && !term_exists(intval($listing_data['sub_cat']))) {
                $invalid_data['invalid_sub_listing_category'] = __("The selected sub listing category is invalid.", "enginethemes");
            }
        } // end validate listing category

        if (!empty($invalid_data)) {
            $errors = new WP_Error();
            foreach ($invalid_data as $key => $message) {
                $errors->add($key, $message);
            }
            return $errors;
        }

        /**
         * Filter validate listing data result
         *
         * @param bool TRUE
         * @param array $listing_data
         *
         * @since 1.0
         */
        return apply_filters('marketengine_validate_listing_data', true, $listing_data);
    }
}