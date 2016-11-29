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
class ME_Inquiry_Handle
{
    /**
     * Handle buyer inquire a listing
     * @param array $data
     *                - string : content The inquiry message content
     *                - int : inquiry_listing The inquired listing id
     * @return Int | WP_Error Return inquiry id if success | WP_Error if false
     *
     * @since 1.0
     */
    public static function inquiry($data)
    {
        $current_user_id = get_current_user_id();

        if (empty($data['send_inquiry'])) {
            return new WP_Error('empty_listing', __("The listing is required.", "enginethemes"));
        }

        //TODO: validate listing id
        $listing_id = $data['send_inquiry'];
        $listing    = me_get_listing($listing_id);

        if ('contact' != $listing->get_listing_type()) {
            return new WP_Error('invalid_listing', __("Invalid listing.", "enginethemes"));
        }

        if ($current_user_id == $listing->post_author) {
            return new WP_Error('inquire_yourself', __("You can not inquire your self.", "enginethemes"));
        }

        if (!ME()->get_current_user()->is_activated()) {
            return new WP_Error('not_activation', __("You can must confirm your email account to start this conversation.", "enginethemes"));
        }

        if (is_wp_error($listing) || $listing->post_type != 'listing') {
            return new WP_Error('invalid_listing', __("Invalid listing.", "enginethemes"));
        }

        $inquiry_id = me_get_current_inquiry($listing_id);

        if (!$inquiry_id) {
            // create inquiry
            $inquiry_id = me_insert_message(
                array(
                    'post_content' => 'Inquiry listing #' . $listing_id,
                    'post_title'   => 'Inquiry listing #' . $listing_id,
                    'post_type'    => 'inquiry',
                    'receiver'     => get_post_field('post_author', $listing_id),
                    'post_parent'  => $listing_id,
                    'sender'       => $current_user_id,
                ), true
            );
            if (is_wp_error($inquiry_id)) {
                return $inquiry_id;
            }
        }

        return $inquiry_id;
    }

    /**
     * Insert a message in a inquiry conversation
     * @param array $data
     *                - string : content The inquiry message content
     *                - int : inquiry_id The inquiry conversation id
     * @return Int | WP_Error Return message id if success | WP_Error if false
     *
     * @since 1.0
     */
    public static function insert_message($message_data)
    {
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
                'sender'       => $current_user,
                'post_content' => $message_data['content'],
                'post_title'   => 'Message listing #' . $message_data['listing_id'],
                'post_type'    => 'message',
                'receiver'     => $receiver,
                'post_parent'  => $message_data['inquiry_id'],
            );

            return me_insert_message($message_data, true);

        } else {
            return new WP_Error('invalid_inquiry', __("Invalid inquiry.", "enginethemes"));
        }

    }

    /**
     * Send a message to an inquiry conversation
     *
     * @param array $data
     *                - int : inquiry_listing The inquired listing id
     *                - string : content The inquiry message content
     *                - int : inquiry_id The inquiry conversation id
     * @return Int | WP_Error Return message id if success | WP_Error if false
     *
     * @since 1.0
     */
    public static function message($data)
    {
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

    /**
     * Retrieve listing contact list
     */
    public static function get_contact_list($args)
    {
        if (!empty($args['s'])) {
            $search_string = stripslashes($args['s']);
            $search_string = trim(mb_strtolower($search_string));

            $users_1         = new WP_User_Query(array(
                'search'         => "*{$search_string}*",
                'search_fields' => array(
                    'user_nicename',
                    'display_name',
                ),
                'fields'         => 'ID',
            ));

            $users_found = $users_1->get_results();
            var_dump($users_found);
            // no contact found
            if (empty($users_found)) {
                ob_start();
                me_get_template('inquiry/contact-item-notfound');
                $content = ob_get_clean();
                return array(
                    'found_posts' => 0,
                    'content'     => $content,
                );
            }
            $args['author__in'] = $users_found;
            unset($args['s']);
        }

        ob_start();
        $messages = new ME_Message_Query($args);

        if ($messages->have_posts()) {
            while ($messages->have_posts()): $messages->the_post();
                me_get_template('inquiry/contact-item', array('current_inquiry' => $args['inquiry_id']));
            endwhile;
        } else {
            if($args['page'] == 1) {
                me_get_template('inquiry/contact-item-notfound');    
            }
        }
        $content = ob_get_clean();
        return array(
            'found_posts' => $messages->found_posts,
            'content'     => $content,
        );
    }
}
