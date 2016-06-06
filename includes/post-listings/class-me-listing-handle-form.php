<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Listing_Handle_Form extends ME_Form {
    public static function init_hook() {
        add_action('wp_loaded', array(__CLASS__, 'process_insert'));
        add_action('wp_loaded', array(__CLASS__, 'process_update'));
        add_action('wp_ajax_me-load-sub-category', array(__CLASS__, 'load_sub_category'));
        add_action('wp_ajax_nopriv_me-load-sub-category', array(__CLASS__, 'load_sub_category'));
    }
    /**
     * Handling listing data to create new listing
     */
    public static function process_insert($data) {
        if (!empty($_POST['insert_lisiting']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-insert-listing')) {
            $new_listing = ME_Listing_Handle::insert($_POST);
            if (is_wp_error($new_listing)) {
                me_wp_error_to_notices($new_listing);
            } else {
                // set the redirect link after submit new listing
                if (isset($_POST['redirect'])) {
                    $redirect = $_POST['redirect'];
                } else {
                    $redirect = get_permalink($new_listing->ID);
                }
                /**
                 * action filter redirect link after user submit a new listing
                 * @param String $redirect
                 * @param Object $new_listing Listing object
                 * @since 1.0
                 * @author EngineTeam
                 */
                $redirect = apply_filters('marketengine_insert_listing_redirect', $redirect, $new_listing);
                wp_redirect($redirect, 302);
                exit;
            }
        }
    }
    /**
     * Handling listing data to update
     */
    public static function process_update($data) {
        if (!empty($_POST['update_lisiting']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-update-listing')) {
            $listing = ME_Listing_Handle::update($_POST);
            if (is_wp_error($new_listing)) {
                me_wp_error_to_notices($listing);
            } else {
                // set the redirect link after update listing
                if (isset($_POST['redirect'])) {
                    $redirect = $_POST['redirect'];
                } else {
                    $redirect = get_permalink($listing->ID);
                }
                /**
                 * action filter redirect link after user update listing
                 * @param String $redirect
                 * @param Object $listing Listing object
                 * @since 1.0
                 * @author EngineTeam
                 */
                $redirect = apply_filters('marketengine_update_listing_redirect', $redirect, $listing);
                wp_redirect($redirect, 302);
                exit;
            }
        }
    }

    public static function process_upload_gallery() {
        // TODO: photo upload, featured image
    }

    public static function load_sub_category() {
        if (isset($_REQUEST['parent-cat'])) {
            ob_start();
            me_get_template_part('post-listing/sub-cat');
            $content = ob_get_clean();
            wp_send_json_success($content);
        }
    }
}

ME_Listing_Handle_Form::init_hook();