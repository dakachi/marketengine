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
        if (isset($_FILES['listing_gallery'])) {
            $maximum_files_allowed = apply_filters('marketengine_plupload_maximum_files_allowed', 2);
            $number_of_files = count($_FILES['listing_gallery']['name']);
            if ($number_of_files > $maximum_files_allowed) {
                return new WP_Error('over_maximum_files_allowed', sprintf(__("You can only add %d image(s) to listing gallery.", "enginethemes"), $maximum_files_allowed));
            }
        }

        if (isset($_FILES['listing_image'])) {
            // process upload featured image
            $featured_image = self::process_feature_image($_FILES['listing_image']);
            if (!is_wp_error($featured_image)) {
                $listing_data['meta_input']['_thumbnail_id'] = $featured_image;
            }else {
                return $featured_image;
            }
        }

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

        if (isset($_FILES['listing_gallery'])) {
            //process upload image gallery
            $galleries = self::process_gallery($_FILES['listing_gallery'], $post);
            update_post_meta( $post, '_me_listing_gallery', $galleries);
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
        if(!empty($listing_data['listing_tag'])) {
            $listing_data['tax_input']['listing_tag'] = $listing_data['listing_tag'];
        }
        // set listing status
        if (self::current_user_can_publish_listing()) {
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
     * Process upload listing featured image
     *
     * @param array $files The submit file from client
     *      - string name 
     *      - int  size 
     *      - string type
     *      - string  tmp_name
     *
     * @since 1.0
     *
     * @return int The attachment id
     */
    public static function process_feature_image($files) {
        return self::process_file_upload($files);
    }

    /**
     * Process upload listing gallery
     *
     * @param array $files The submit file from client
     *      - string name 
     *      - int  size 
     *      - string type
     *      - string  tmp_name
     * @param int $parent The attachment parent post
     *
     * @since 1.0
     *
     * @return array The array of attachment id
     */
    public static function process_gallery($files, $parent = 0) {
        $gallery = array();
        foreach ($files['name'] as $key => $value) {
            $file = array(
                'name' => $files['name'][$key],
                'size' => $files['size'][$key],
                'type' => $files['type'][$key],
                'tmp_name' => $files['tmp_name'][$key],
            );
            $attach_id = self::process_file_upload($file, $parent);
            if (!is_wp_error($attach_id)) {
                array_push($gallery, $attach_id);
            }
        }
        return $gallery;
    }

    /**
     * Process upload file
     *
     * @param array $files The submit file from client
     *      - string name 
     *      - int  size 
     *      - string type
     *      - string  tmp_name
     * @param int $parent The attachment parent post
     * @param int $author The post author
     *
     * @since 1.0
     *
     * @return array The array of attachment id
     */
    public static function process_file_upload($file,  $parent = 0, $author = 0) {

        global $user_ID;
        $author = (0 == $author || !is_numeric($author)) ? $user_ID : $author;

        if (isset($file['name']) && $file['size'] > 0) {

            // setup the overrides
            $overrides['test_form'] = false;

            // this function also check the filetype & return errors if having any
            if (!function_exists('wp_handle_upload')) {
                require_once ABSPATH . 'wp-admin/includes/file.php';
            }
            $uploaded_file = wp_handle_upload($file, $overrides);

            //if there was an error quit early
            if (isset($uploaded_file['error'])) {
                return new WP_Error('upload_error', $uploaded_file['error']);
            } elseif (isset($uploaded_file['file'])) {

                // The wp_insert_attachment function needs the literal system path, which was passed back from wp_handle_upload
                $file_name_and_location = $uploaded_file['file'];

                // Generate a title for the image that'll be used in the media library
                $file_title_for_media_library = sanitize_file_name($file['name']);

                $wp_upload_dir = wp_upload_dir();

                // Set up options array to add this file as an attachment
                $attachment = array(
                    'guid' => $uploaded_file['url'],
                    'post_mime_type' => $uploaded_file['type'],
                    'post_title' => $file_title_for_media_library,
                    'post_content' => '',
                    'post_status' => 'inherit',
                    'post_author' => $author,
                );
                /**
                 * Run the wp_insert_attachment function.This adds the file to the media library and generates the thumbnails.
                 * If you wanted to attch this image to a post, you could pass the post id as a third param and it'd magically happen.
                 */
                $attach_id = wp_insert_attachment($attachment, $file_name_and_location, $parent);
                require_once ABSPATH . "wp-admin" . '/includes/image.php';
                $attach_data = wp_generate_attachment_metadata($attach_id, $file_name_and_location);
                wp_update_attachment_metadata($attach_id, $attach_data);
                return $attach_id;
            } else {
                // wp_handle_upload returned some kind of error. the return does contain error details, so you can use it here if you want.
                return new WP_Error('upload_error', __('There was a problem with your upload.', "enginethemes"));
            }
        }
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