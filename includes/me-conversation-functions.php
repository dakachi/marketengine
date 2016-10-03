<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * MarketEngine create a message
 *
 * @param array $message_arr The message data
 * @param bool $wp_error Return WP_Error when error occur
 *
 * @return WP_Error | int
 * @since 1.0
 *
 * @author EngineTeam
 */
function me_insert_message($message_arr, $wp_error = false) {
    global $wpdb;

    $user_id = get_current_user_id();

    if (empty($user_id)) {
        if ($wp_error) {
            return new WP_Error('empty_receiver', __('Sender is empty.'));
        } else {
            return 0;
        }
    }

    $defaults = array(
        'sender'                => $user_id,
        'receiver'              => '',
        'post_content'          => '',
        'post_content_filtered' => '',
        'post_title'            => '',
        'post_excerpt'          => '',
        'post_status'           => 'sent',
        'post_type'             => 'inquiry',
        'post_password'         => '',
        'post_parent'           => 0,
        'guid'                  => '',
    );

    $message_arr = wp_parse_args($message_arr, $defaults);

    $message_arr = sanitize_post($message_arr, 'db');
    // Are we updating or creating?
    $message_ID = 0;
    $update     = false;
    $guid       = $message_arr['guid'];

    if (!empty($message_arr['ID'])) {
        $update = true;

        // Get the post ID and GUID.
        $message_ID     = $message_arr['ID'];
        $message_before = me_get_message($message_ID);
        if (is_null($message_before)) {
            if ($wp_error) {
                return new WP_Error('invalid_post', __('Invalid message ID.'));
            }
            return 0;
        }

        $guid            = me_get_message_field('guid', $message_ID);
        $previous_status = me_get_message_field('message_status', $message_ID); // get_post_field
    } else {
        $previous_status = 'new';
    }

    $post_type = empty($message_arr['post_type']) ? 'message' : $message_arr['post_type'];

    $post_title   = $message_arr['post_title'];
    $post_content = $message_arr['post_content'];
    $post_excerpt = $message_arr['post_excerpt'];
    if (isset($message_arr['post_name'])) {
        $post_name = $message_arr['post_name'];
    } elseif ($update) {
        // For an update, don't modify the post_name if it wasn't supplied as an argument.
        $post_name = $message_before->post_name;
    }

    $maybe_empty = 'attachment' !== $post_type && !$post_content;

    /**
     * Filters whether the message should be considered "empty".
     *
     * Returning a truthy value to the filter will effectively short-circuit
     * the new post being inserted, returning 0. If $wp_error is true, a WP_Error
     * will be returned instead.
     *
     * @since 1.0
     *
     * @param bool  $maybe_empty Whether the post should be considered "empty".
     * @param array $message_arr     Array of post data.
     */
    if (apply_filters('me_insert_message_empty_content', $maybe_empty, $message_arr)) {
        if ($wp_error) {
            return new WP_Error('empty_content', __('Content, title, and excerpt are empty.', 'enginethemes'));
        } else {
            return 0;
        }
    }

    if (empty($message_arr['receiver'])) {
        if ($wp_error) {
            return new WP_Error('empty_receiver', __('Receiver is empty.', 'enginethemes'));
        } else {
            return 0;
        }
    }

    if ($message_arr['receiver'] == $message_arr['sender']) {
        if ($wp_error) {
            return new WP_Error('send_to_yourself', __('You can not send message to your self.', 'enginethemes'));
        } else {
            return 0;
        }
    }

    $post_status = empty($message_arr['post_status']) ? 'sent' : $message_arr['post_status'];

    /*
     * If the post date is empty (due to having been new or a draft) and status
     * is not 'draft' or 'pending', set date to now.
     */
    if (empty($message_arr['post_date_gmt']) || '0000-00-00 00:00:00' == $message_arr['post_date_gmt']) {
        $post_date = current_time('mysql');
    } else {
        $post_date = get_date_from_gmt($message_arr['post_date_gmt']);
    }

    if (!in_array($post_status, array('draft', 'pending', 'auto-draft'))) {
        $post_date_gmt = get_gmt_from_date($post_date);
    } else {
        $post_date_gmt = '0000-00-00 00:00:00';
    }

    if ($update || '0000-00-00 00:00:00' == $post_date) {
        $post_modified     = current_time('mysql');
        $post_modified_gmt = current_time('mysql', 1);
    } else {
        $post_modified     = $post_date;
        $post_modified_gmt = $post_date_gmt;
    }

    // These variables are needed by compact() later.
    $post_content_filtered = $message_arr['post_content_filtered'];
    $sender                = $user_id;
    $receiver              = $message_arr['receiver'];

    if (isset($message_arr['post_parent'])) {
        $post_parent = (int) $message_arr['post_parent'];
    } else {
        $post_parent = 0;
    }

    // Expected_slashed (everything!).
    $data  = compact('sender', 'receiver', 'post_date', 'post_date_gmt', 'post_content', 'post_content_filtered', 'post_title', 'post_excerpt', 'post_status', 'post_type', 'post_password', 'post_name', 'post_modified', 'post_modified_gmt', 'post_parent', 'guid');
    $data  = wp_unslash($data);
    $where = array('ID' => $message_ID);

    $message_table = $wpdb->prefix . 'marketengine_message_item';
    if ($update) {
        /**
         * Fires immediately before an existing post is updated in the database.
         *
         * @since 2.5.0
         *
         * @param int   $message_ID Message ID.
         * @param array $data    Array of unslashed post data.
         */
        do_action('pre_message_update', $message_ID, $data);
        if (false === $wpdb->update($message_table, $data, $where)) {
            if ($wp_error) {
                return new WP_Error('db_update_error', __('Could not update post in the database', 'enginethemes'), $wpdb->last_error);
            } else {
                return 0;
            }
        }
    } else {
        // If there is a suggested ID, use it if not already present.
        if (!empty($import_id)) {
            $import_id = (int) $import_id;
            if (!$wpdb->get_var($wpdb->prepare("SELECT ID FROM $message_table WHERE ID = %d", $import_id))) {
                $data['ID'] = $import_id;
            }
        }
        if (false === $wpdb->insert($message_table, $data)) {
            if ($wp_error) {
                return new WP_Error('db_insert_error', __('Could not insert post into the database', 'enginethemes'), $wpdb->last_error);
            } else {
                return 0;
            }
        }
        $message_ID = (int) $wpdb->insert_id;

        // Use the newly generated $message_ID.
        $where = array('ID' => $message_ID);
    }

    // TODO: message meta
    if (!empty($message_arr['meta_input'])) {
        foreach ($message_arr['meta_input'] as $field => $value) {
            update_post_meta($message_ID, $field, $value);
        }
    }

    $message = me_get_message($message_ID);
    if ($update) {
        /**
         * Fires once an existing message has been updated.
         *
         * @since 1.0
         *
         * @param int     $message_ID   Message ID.
         * @param ME_Message $post         Message object.
         */
        do_action('edit_message', $message_ID, $message);
        $message_after = me_get_message($message_ID);

        /**
         * Fires once an existing message has been updated.
         *
         * @since 1.0
         *
         * @param int     $message_ID      Message ID.
         * @param ME_Message $message_after   Message object following the update.
         * @param ME_Message $message_before  Message object before the update.
         */
        do_action('message_updated', $message_ID, $message_after, $message_before);
    }

    /**
     * Fires once a message has been saved.
     *
     * The dynamic portion of the hook name, `$message->post_type`, refers to
     * the message type slug.
     *
     * @since 1.0
     *
     * @param int     $message_ID message ID.
     * @param ME_Message $message    message object.
     * @param bool    $update  Whether this is an existing message being updated or not.
     */
    do_action("save_message_{$message->post_type}", $message_ID, $message, $update);

    /**
     * Fires once a message has been saved.
     *
     * @since 1.0
     *
     * @param int     $message_ID message ID.
     * @param ME_Message $message    message object.
     * @param bool    $update  Whether this is an existing message being updated or not.
     */
    do_action('save_message', $message_ID, $message, $update);

    /**
     * Fires once a message has been saved.
     *
     * @since 1.0
     *
     * @param int     $message_ID message ID.
     * @param ME_Message $message    message object.
     * @param bool    $update  Whether this is an existing message being updated or not.
     */
    do_action('me_insert_message', $message_ID, $message, $update);

    return $message_ID;
}

/**
 * MarketEngine update a message
 *
 * @param array $message_arr The message data
 * @param bool $wp_error Return WP_Error when error occur
 *
 * @return WP_Error | int
 * @since 1.0
 *
 * @author EngineTeam
 */
function me_update_message($message_arr = array(), $wp_error = false) {
    if (is_object($message_arr)) {
        // Non-escaped post was passed.
        $message_arr = get_object_vars($message_arr);
        $message_arr = wp_slash($message_arr);
    }

    // First, get all of the original fields.
    $post = me_get_message($message_arr['ID'], ARRAY_A);

    if (is_null($post)) {
        if ($wp_error) {
            return new WP_Error('invalid_post', __('Invalid post ID.'));
        }

        return 0;
    }

    // Escape data pulled from DB.
    $post = wp_slash($post);

    // Drafts shouldn't be assigned a date unless explicitly done so by the user.
    if (isset($post['post_status']) && in_array($post['post_status'], array('draft', 'pending', 'auto-draft')) && empty($message_arr['edit_date']) &&
        ('0000-00-00 00:00:00' == $post['post_date_gmt'])) {
        $clear_date = true;
    } else {
        $clear_date = false;
    }

    // Merge old and new fields with new fields overwriting old ones.
    $message_arr = array_merge($post, $message_arr);
    if ($clear_date) {
        $message_arr['post_date']     = current_time('mysql');
        $message_arr['post_date_gmt'] = '';
    }

    return me_insert_message($message_arr, $wp_error);
}

// TODO: archive message
function me_archive_message() {

}

// TODO: delete message
function me_delete_message() {

}

/**
 * Retrieve messages statuses list
 * @return Array
 * @author EngineThemes
 */
function me_get_message_status_list() {
    return apply_filters('me_message_status_list', array(
        'sent'    => __("Sent", "enginethemes"),
        'read'    => __("Seen", "enginethemes"),
        'archive' => __("Archived", "enginethemes"),
    ));
}

/**
 * Retrieve messages types list
 * @return Array
 * @author EngineThemes
 */
function me_get_message_types() {
    return apply_filters('me_message_status_list', array(
        'inquiry' => __("Inquiry", "enginethemes"),
        'inbox'   => __("Inbox", "enginethemes"),
    ));
}

/**
 * Retrieve list of latest messages or messages matching criteria.
 *
 * The defaults are as follows:
 *
 * @since 1.0
 *
 * @see ME_Message_Query::parse_query()
 *
 * @param array $args {
 *     Optional. Arguments to retrieve messages. See ME_Message_Query::parse_query() for all
 *     available arguments.
 *
 *     @type int        $numberposts      Total number of posts to retrieve. Is an alias of $posts_per_page
 *                                        in ME_Message_Query. Accepts -1 for all. Default 5.
 *     @type array      $include          An array of post IDs to retrieve, sticky posts will be included.
 *                                        Is an alias of $post__in in ME_Message_Query. Default empty array.
 *     @type array      $exclude          An array of post IDs not to retrieve. Default empty array.
 *     @type bool       $suppress_filters Whether to suppress filters. Default true.
 * }
 * @return array List of messages.
 */
function me_get_messages($args = null) {
    $defaults = array(
        'numberposts'      => 10,
        'orderby'          => 'date',
        'order'            => 'DESC',
        'post_type'        => 'post',
    );

    $r = wp_parse_args($args, $defaults);
    if (empty($r['post_status'])) {
        $r['post_status'] =  'sent';
    }

    if (!empty($r['numberposts']) && empty($r['posts_per_page'])) {
        $r['posts_per_page'] = $r['numberposts'];
    }

    if (!empty($r['include'])) {
        $incposts            = wp_parse_id_list($r['include']);
        $r['posts_per_page'] = count($incposts); // only the number of posts included
        $r['post__in']       = $incposts;
    } elseif (!empty($r['exclude'])) {
        $r['post__not_in'] = wp_parse_id_list($r['exclude']);
    }

    $r['ignore_sticky_posts'] = true;
    $r['no_found_rows']       = true;

    $get_posts = new ME_Message_Query;
    return $get_posts->query($r);
}

/**
 * Retrieves message data given a message ID or message object.
 *
 * See sanitize_post() for optional $filter values. Also, the parameter
 * `$message`, must be given as a variable, since it is passed by reference.
 *
 * @since 1.5.1
 *
 * @global ME_Message $message
 *
 * @param int|ME_Message|null $message   Optional. Post ID or message object. Defaults to global $message.
 * @param string           $output Optional, default is Object. Accepts OBJECT, ARRAY_A, or ARRAY_N.
 *                                 Default OBJECT.
 * @param string           $filter Optional. Type of filter to apply. Accepts 'raw', 'edit', 'db',
 *                                 or 'display'. Default 'raw'.
 * @return ME_Message|array|null Type corresponding to $output on success or null on failure.
 *                            When $output is OBJECT, a `ME_Message` instance is returned.
 */
function me_get_message($message = null, $output = OBJECT, $filter = 'raw') {
    if (empty($message) && isset($GLOBALS['message'])) {
        $message = $GLOBALS['message'];
    }

    if ($message instanceof ME_Message) {
        $_message = $message;
    } elseif (is_object($message)) {
        if (empty($message->filter)) {
            $_message = sanitize_post($message, 'raw');
            $_message = new ME_Message($_message);
        } elseif ('raw' == $message->filter) {
            $_message = new ME_Message($message);
        } else {
            $_message = ME_Message::get_instance($message->ID);
        }
    } else {
        $_message = ME_Message::get_instance($message);
    }

    if (!$_message) {
        return null;
    }

    $_message = $_message->filter($filter);

    if ($output == ARRAY_A) {
        return $_message->to_array();
    } elseif ($output == ARRAY_N) {
        return array_values($_message->to_array());
    }

    return $_message;
}
/**
 * Retrieve data from a message field based on message ID.
 *
 * Examples of the message field will be, 'post_type', 'post_status', 'post_content',
 * etc and based off of the post object property or key names.
 *
 * The context values are based off of the filter functions and
 * supported values are found within those functions.
 *
 * @since 1.0
 *
 * @see sanitize_post_field()
 *
 * @param string      $field   Message field name.
 * @param int|ME_Message $post    Optional. Message ID or Message object
 * @param string      $context Optional. How to filter the field. Accepts 'raw', 'edit', 'db',
 *                             or 'display'. Default 'display'.
 * @return string The value of the message field on success, empty string on failure.
 */
function me_get_message_field($field, $message, $context = 'display') {
    $message = me_get_message($message);

    if (!$message) {
        return '';
    }

    if (!isset($message->$field)) {
        return '';
    }
    return sanitize_post_field($field, $message->$field, $message->ID, $context);
}

/**
 * Retrieve message item meta field for a message item.
 *
 * @since 1.0
 *
 * @param int    $message_id    message ID.
 * @param string $key     Optional. The meta key to retrieve. By default, returns data for all keys. Default empty.
 * @param bool   $single  Optional. Whether to return a single value. Default false.
 *                           Default false.
 * @return mixed Will be an array if $single is false. Will be value of meta data field if $single is true.
 */
function me_get_message_meta($mesage_id, $key = '', $single = false) {
    return get_metadata('marketengine_message_item', $message_id, $key, $single);
}

/**
 * Add meta data field to a message item
 *
 * @since 1.0
 *
 * @param int    $message_id Message ID.
 * @param string $meta_key   Metadata name.
 * @param mixed  $meta_value Metadata value. Must be serializable if non-scalar.
 * @param bool   $unique     Optional. Whether the same key should not be added.
 *                           Default false.
 * @return int|false Meta ID on success, false on failure.
 */
function me_add_message_meta($message_id, $meta_key, $meta_value, $unique = true) {
    return add_metadata('marketengine_message_item', $mesage_id, $meta_key, $meta_value, $unique);
}

/**
 *  Update Message meta field based on mesage_id.
 *
 * @since 1.0
 *
 * @param int    $message_id Message ID.
 * @param string $meta_key   Metadata name.
 * @param mixed  $meta_value Metadata value. Must be serializable if non-scalar.
 * @param mixed  $prev_value Optional. Previous value to check before removing.
 *                           Default empty.
 * @return int|false Meta ID if the key didn't exist, true on successful update, false on failure.
 */
function me_update_message_meta($mesage_id, $meta_key, $meta_value, $prev_value = '') {
    return update_metadata('marketengine_message_item', $message_id, $meta_key, $meta_value, $prev_value);
}

/**
 * Remove metadata matching criteria from a message item.
 *
 * @since 1.0
 *
 * @param int    $mesage_id  Message ID.
 * @param string $meta_key   Metadata name.
 * @param mixed  $meta_value Metadata value. Must be serializable if non-scalar.
 *
 * @return bool True on success, false on failure.
 */
function me_delete_message_meta($mesage_id, $meta_key, $meta_value = '') {
    return delete_metadata('marketengine_message_item', $message_id, $meta_key, $meta_value);
}

// add_action('init', 'test_message_query');
// function test_message_query() {
//     // $result = me_insert_message(
//     //     array('post_title' => 'abc', 'post_content' => 'xyz', 'post_excerpt' => 'qwerty', 'receiver' => 2),
//     //     true
//     // );
//     // echo "<pre>";
//     // print_r($result);
//     // echo "</pre>";
//     $message_query = new ME_Message_Query(array('post_type' => 'post', 'post_status' => 'draft', 's' => 'po'));
//     echo "<pre>";
//     global $message;
//     while ($message_query->have_posts()) { $message_query->the_post();
//         print_r($message);
//     }
//     echo "</pre>";
// }