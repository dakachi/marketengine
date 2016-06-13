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



        $listing_data['post_type'] = 'listing';
        if (isset($listing_data['ID'])) {
            if (($listing_data['post_author'] != $user_ID) && !current_user_can('edit_others_posts')) {
                return new WP_Error('edit_others_posts', __("You are not allowed to edit posts as this user.", "enginethemes"));
            }
            $post = wp_update_post($listing_data);
        } else {
            if (!self::current_user_can_create_lisitng()) {
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
     * Check current user create post capability
     *
     * @since 1.0
     *
     * @return bool
     */
    public static function current_user_can_create_lisitng() {
        global $user_ID;
        return apply_filters('marketengine_user_can_create_listing', true, $user_ID);
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

        $listing_data['post_title'] = $listing_data['listing_title'];
        $listing_data['post_content'] = $listing_data['listing_content'];
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

        if (!empty($invalid_data)) {
            $errors = new WP_Error();
            foreach ($invalid_data as $key => $message) {
                $errors->add($key, $message);
            }
            return $errors;
        }

        $is_valid = self::handle_listing_category($listing_data);
        /**
         * Filter validate listing data result
         *
         * @param bool TRUE
         * @param array $listing_data
         *
         * @since 1.0
         */
        return apply_filters('marketengine_validate_listing_data', $is_valid, $listing_data);
    }

    public static function handle_listing_category($listing_data) {
        $errors = new WP_Error();
        if (empty($listing_data['parent_cat'])) {
            $errors->add('listing_category', __("The listing category field is required.", "enginethemes"));
            return $errors;
        }

        if (!term_exists($listing_data['parent_cat'], 'listing_category')) {
            $errors->add('invalid_listing_category', __("The selected listing category is invalid.", "enginethemes"));
            return $errors;
        }

        $child_cats = get_terms('listing_category', array('hide_empty' => false, 'parent' => $listing_data['parent_cat']));
        if (!empty($child_cats) && empty($listing_data['sub_cat'])) {
            $errors->add('sub_listing_category', __("The sub listing category field is required.", "enginethemes"));
            return $errors;
        }

        if (!term_exists($listing_data['sub_cat'])) {
            $errors->add('invalid_sub_listing_category', __("The selected sub listing category is invalid.", "enginethemes"));
            return $errors;
        }

        return true;
    }

    public static function handle_listing_tag($listing_data) {

    }
}
