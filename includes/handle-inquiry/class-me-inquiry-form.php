<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * ME_Inquiry_Form
 *
 * Handle submit, ajax inquire listing
 *
 * @version     1.0
 * @package     Includes/Handle-inquiry
 * @author      EngineThemesTeam
 * @category    Class
 */
class ME_Inquiry_Form {
    public static function init_hook() {
        // parse_request
        add_action('wp_loaded', array(__CLASS__, 'process_start_inquiry'));
        add_action('wp_loaded', array(__CLASS__, 'send_inquiry'));

        add_action('wp_ajax_get_messages', array(__CLASS__, 'fetch_messages'));
        add_action('wp_ajax_get_contact_list', array(__CLASS__, 'fetch_contact_list'));
        add_action('wp_ajax_me_send_message', array(__CLASS__, 'send_message'));


        add_filter('the_marketengine_message', array(__CLASS__, 'filter_message'));

    }

    /**
     * Buyer start inquiry listing in listiting details
     */
    public static function process_start_inquiry() {
        if (isset($_POST['send_inquiry']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-send-inquiry')) {
            // check user login
            $redirect = me_get_page_permalink('inquiry');

            $id = me_get_current_inquiry($_POST['send_inquiry']);
            if (!$id) {
                $redirect = add_query_arg(array('id' => $_POST['send_inquiry']), $redirect);
                wp_redirect($redirect);
                exit;
            } else {
                $redirect = add_query_arg(array('inquiry_id' => $id), $redirect);
                wp_redirect($redirect);
                exit;
            }
        }
    }

    /**
     * Buyer send a new inquiry to a listing owner
     */
    public static function send_inquiry() {
        // send inquiry to listing's owner
        if (isset($_POST['content']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-post-inquiry')) {
            $result = ME_Inquiry_Handle::inquiry($_POST);
            if (is_wp_error($result)) {
                me_wp_error_to_notices($result);
            } else {
                $redirect = me_get_page_permalink('inquiry');
                $redirect = add_query_arg(array('inquiry_id' => $result), $redirect);
                wp_redirect($redirect);
                exit;
            }
        }
    }

    /**
     * User send message in a inquiry conversation
     */
    public static function send_message() {
        // send message in an inquiry
        if (isset($_POST['content']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-inquiry-message')) {
            $result = ME_Inquiry_Handle::message($_POST);
            if (is_wp_error($result)) {
                wp_send_json( array('success' => 'false', 'msg' => $result->get_error_message()) );
            } else {
                $message = me_get_message($result);
                ob_start();
                me_get_template('inquiry/message-item', array('message' => $message));
                $content = ob_get_clean();
                wp_send_json( array('success' => true, 'content' => $content ) );
            }
        }
    }

    /**
     * User fetch the older messages
     */
    public static function fetch_messages() {
        if (!empty($_GET['parent']) && !empty($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'me-inquiry-message')) {
            $parent  = me_get_message($_GET['parent']);
            $user_id = get_current_user_id();
            if ($parent->receiver != $user_id && $parent->sender != $user_id) {
                wp_send_json(array('success' => false));
            }
            $messages = me_get_messages(array('post_type' => 'message', 'post_parent' => $_GET['parent'], 'paged' => $_GET['paged']));
            $messages = array_reverse($messages);
            ob_start();
            foreach ($messages as $key => $message) {
                me_get_template('inquiry/message-item', array('message' => $message));
            }
            $content = ob_get_clean();

            wp_send_json(array('success' => true, 'data' => $content));
        }
    }

    /**
     * Seller load the inquiry contact list
     */
    public static function fetch_contact_list() {
        if (!empty($_GET['listing'])) {
            $user_id = get_current_user_id();
            $listing = get_post($_GET['listing']);

            $paged = $_GET['paged'];

            if ($listing->post_author != $user_id) {
                wp_send_json(array('success' => false));
            }
            $args = array(
                'paged'       => $paged,
                'post_parent' => $listing->ID,
                'post_type'   => 'inquiry'
            );
            $messages = new ME_Message_Query($args);

            ob_start();
            while ($messages->have_posts()): $messages->the_post();
                me_get_template('inquiry/contact-item');
            endwhile;
            $content = ob_get_clean();

            wp_send_json(array('success' => true, 'data' => $content));
        }
    }


    public static function filter_message($content) {
    	$content = nl2br(esc_html( $content ));
    	$content = do_shortcode( $content );
    	return $content;
    }

}
ME_Inquiry_Form::init_hook();