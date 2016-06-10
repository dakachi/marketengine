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
        if (is_taxonomy_hierarchical($taxonomy)) {
            return false;
        }
        return apply_filters('marketengine_user_can_create_$taxonomy', true, $user_ID);
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
        /**
         * Filter listing taxonomy data validate rule
         *
         * @param array $listing_tax_rules
         *
         * @since 1.0
         */
        $listing_tax_rules = apply_filters('marketengine_insert_listing_taxonomy_rules', array('listing_category' => 'required'));
        $is_valid = me_validate($listing_data['tax_input'], $listing_tax_rules);
        if (!$is_valid) {
            $invalid_data = array_merge($invalid_data, me_get_invalid_message($listing_data['tax_input'], $listing_tax_rules));
        }

        if (!empty($invalid_data)) {
            $errors = new WP_Error();
            foreach ($invalid_data as $key => $message) {
                $errors->add($key, $message);
            }
            return $errors;
        }
        return true;
    }

    //TODO: insert gallery

    public static function handle_taxonomy($post_data) {
        // Convert taxonomy input to term IDs, to avoid ambiguity.
        if (isset($post_data['tax_input'])) {
            foreach ((array) $post_data['tax_input'] as $taxonomy => $terms) {
                // Hierarchical taxonomy data is already sent as term IDs, so no conversion is necessary.
                if (is_taxonomy_hierarchical($taxonomy)) {
                    continue;
                }
                /*
                 * Assume that a 'tax_input' string is a comma-separated list of term names.
                 * Some languages may use a character other than a comma as a delimiter, so we standardize on
                 * commas before parsing the list.
                 */
                if (!is_array($terms)) {
                    $comma = _x(',', 'tag delimiter');
                    if (',' !== $comma) {
                        $terms = str_replace($comma, ',', $terms);
                    }
                    $terms = explode(',', trim($terms, " \n\t\r\0\x0B,"));
                }

                $clean_terms = array();
                foreach ($terms as $term) {
                    // Empty terms are invalid input.
                    if (empty($term)) {
                        continue;
                    }

                    $_term = get_terms($taxonomy, array(
                        'name' => $term,
                        'fields' => 'ids',
                        'hide_empty' => false,
                    ));

                    if (!empty($_term)) {
                        $clean_terms[] = intval($_term[0]);
                    } else {
                        // No existing term was found, so pass the string. A new term will be created.
                        $clean_terms[] = $term;
                    }
                }

                $post_data['tax_input'][$taxonomy] = $clean_terms;
            }
        }
        return $post_data;
    }
}
