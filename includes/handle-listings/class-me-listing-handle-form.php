<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * ME Listing Handle Form
 *
 * Class control listing data submit by user fromt post listing form
 *
 * @version     1.0
 * @package     Includes/Post-Listings
 * @author      Dakachi
 * @category    Class
 */
class ME_Listing_Handle_Form extends ME_Form {
    public static function init_hook() {

        add_action( 'template_redirect', array(__CLASS__, 'redirect_to_login') );

        add_action('wp_loaded', array(__CLASS__, 'process_insert'));
        add_action('wp_loaded', array(__CLASS__, 'process_update'));

        // ajax action
        add_action('wp_ajax_me-load-sub-category', array(__CLASS__, 'load_sub_category'));
        add_action('wp_ajax_nopriv_me-load-sub-category', array(__CLASS__, 'load_sub_category'));        

        add_action('wp_loaded', array(__CLASS__, 'process_review_listing'));
        add_action('transition_comment_status', array(__CLASS__, 'approve_review_callback'), 10, 3);
        add_action('wp_insert_comment', array(__CLASS__,'insert_review_callback'), 10, 2);

    }
    /** 
     * Handle redirect user to page login when not logged in
     */
    public static function redirect_to_login() {
        if(!is_user_logged_in() && is_page( me_get_page_id('post-listing') ) ) {
            $link = me_get_page_permalink('user_account');
            $link = add_query_arg(array('redirect' => get_permalink()), $link);
            wp_redirect( $link );
            exit;
        }
    }
    /**
     * Handling listing data to create new listing
     * @since 1.0
     */
    public static function process_insert($data) {
        if (!empty($_POST['insert_lisiting']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-insert_listing')) {
            $new_listing = ME_Listing_Handle::insert($_POST, $_FILES);
            if (is_wp_error($new_listing)) {
                me_wp_error_to_notices($new_listing);
            } else {
                // set the redirect link after submit new listing
                if (isset($_POST['redirect'])) {
                    $redirect = $_POST['redirect'];
                } else {
                    $redirect = get_permalink($new_listing);
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
     * @since 1.0
     */
    public static function process_update($data) {
        if (!empty($_POST['update_lisiting']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-update_listing')) {
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
    /**
     * Retrieve sub category select template
     * @since 1.0
     */
    public static function load_sub_category() {
        if (isset($_REQUEST['parent-cat'])) {
            ob_start();
            me_get_template('post-listing/sub-cat');
            $content = ob_get_clean();
            wp_send_json_success($content);
        }
    }

    /**
     * Handle review listing
     * @since 1.0
     */
    public static function process_review_listing() {
        if (!empty($_POST['listing_id']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-review-listing')) {
            $review = ME_Listing_Handle::insert_review($_POST);
            if(is_wp_error( $review )) {
                me_wp_error_to_notices($review);
            }else {

            }
        }
    }

    /**
     * @param $new_status
     * @param $old_status
     * @param $comment
     * @since 1.0
     */
    public static function approve_review_callback($new_status, $old_status, $comment) {
        if ($old_status != $new_status) {
            ME_Listing_Handle::update_post_rating($comment->comment_ID, $comment);
        }
    }

    /**
     * catch hook wp_insert_comment to update rating
     * @param int $comment_id
     * @param $comment
     * @since 1.0
     */
    public static function insert_review_callback($comment_id, $comment) {
        ME_Listing_Handle::update_post_rating($comment_id, $comment);
    }

}
ME_Listing_Handle_Form::init_hook();