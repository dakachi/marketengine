<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * ME_Inquiry_Handle
 *
 * Handling buyer inquire listing behavior
 *
 * @class       ME_Inquiry_Handle
 * @version     1.0
 * @package     Includes/Handle-inquiry
 * @author      EngineThemesTeam
 * @category    Class
 */
class ME_Inquiry_Handle {
    /**
     * Handle buyer inquire a listing
     * @param array $data 
     *				- string : content The inquiry message content
     *				- int : inquiry_listing The inquired listing id
     * @return Int | WP_Error Return inquiry id if success | WP_Error if false
     *
     * @since 1.0
     */
    public static function inquiry($data) {

        $content = strip_tags(trim($data['content']));

        if (empty($data['inquiry_listing'])) {
            return new WP_Error('empty_listing', __("The listing is required.", "enginethemes"));
        }

        if (empty($content)) {
            return new WP_Error('empty_inquiry_content', __("The inquiry content is required.", "enginethemes"));
        }
        //TODO: validate listing id
        $listing_id = $data['inquiry_listing'];
        $listing    = get_post($listing_id);

        if (is_wp_error($listing) || $listing->post_type != 'listing') {
            return new WP_Error('invalid_listing', __("Invalid listing.", "enginethemes"));
        }

        $inquiry_id = me_get_current_inquiry($listing_id);
        // strip html tag
        $content = strip_tags(trim($data['content']));
        if (!$inquiry_id) {
            // create inquiry
            $inquiry_id = me_insert_message(
                array(
                    'post_content' => 'Inquiry listing #' . $listing_id,
                    'post_title'   => 'Inquiry listing #' . $listing_id,
                    'post_type'    => 'inquiry',
                    'receiver'     => get_post_field('post_author', $listing_id),
                    'post_parent'  => $listing_id,
                ), true
            );
            if (is_wp_error($inquiry_id)) {
                return $inquiry_id;
            }
        }

        $message_data = array(
            'listing_id' => $listing_id,
            'content'    => $content,
            'inquiry_id' => $inquiry_id,
        );
        $message = self::insert_message($message_data);
        if (is_wp_error($message)) {
            return $message;
        }
        return $inquiry_id;
    }

    /**
     * Insert a message in a inquiry conversation
     * @param array $data 
     *				- string : content The inquiry message content
     *				- int : inquiry_id The inquiry conversation id
     * @return Int | WP_Error Return message id if success | WP_Error if false
     *
     * @since 1.0
     */
    public static function insert_message($message_data) {
        $inquiry_id = $message_data['inquiry_id'];
        if ($inquiry_id) {
            // add message to inquiry
            $current_user = get_current_user_id();
            $inquiry      = me_get_message($message_data['inquiry_id']);

            if (!$inquiry) {
                return new WP_Error('invalid_inquiry', __("Invalid inquiry.", "enginethemes"));
            }

            $message_data['content'] = strip_tags(trim($message_data['content']));

            if (empty($message_data['content'])) {
                return new WP_Error('empty_message_content', __("The message content is required.", "enginethemes"));
            }

            if ($inquiry->sender == $current_user) {
                $receiver = $inquiry->receiver;
            } elseif ($inquiry->receiver == $current_user) {
                $receiver = $inquiry->sender;
            } else {
                return new WP_Error('permission_denied', __("You do not have permision to post message in this inquiry.", "enginethemes"));
            }

            $message_data = array(
                'post_content' => $message_data['content'],
                'post_title'   => 'Message listing #' . $message_data['listing_id'],
                'post_type'    => 'message',
                'receiver'     => $receiver,
                'post_parent'  => $message_data['inquiry_id'],
            );

            $message_id = me_insert_message($message_data, true);
            return $message_id;
        } else {
            return new WP_Error('invalid_inquiry', __("Invalid inquiry.", "enginethemes"));
        }

    }

    /**
     * Send a message to an inquiry conversation
     *
     * @param array $data 
     *				- int : inquiry_listing The inquired listing id
     *				- string : content The inquiry message content
     *				- int : inquiry_id The inquiry conversation id
     * @return Int | WP_Error Return message id if success | WP_Error if false
     *
     * @since 1.0
     */
    public static function message($data) {
        $listing_id = $data['inquiry_listing'];
        $inquiry_id = $data['inquiry_id'];
        // strip html tag
        $content = strip_tags(trim($data['content']));
        // add message
        $message_data = array(
            'listing_id' => $listing_id,
            'content'    => $content,
            'inquiry_id' => $inquiry_id,
        );
        return self::insert_message($message_data);
    }
}
