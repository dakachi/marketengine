<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 *
 */
function me_insert_message($message_arr, $wp_error = false) {
    global $wpdb;

    $user_id = get_current_user_id();

    $defaults = array(
        'sender'                => $user_id,
        'receiver'              => '',
        'post_content'          => '',
        'post_content_filtered' => '',
        'post_title'            => '',
        'post_status'           => 'draft',
        'post_type'             => 'post',
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

    $maybe_empty = 'attachment' !== $post_type
    && !$post_content && !$post_title && !$post_excerpt;

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
            return new WP_Error('empty_content', __('Content, title, and excerpt are empty.'));
        } else {
            return 0;
        }
    }

    if (empty($message_arr['receiver'])) {
        if ($wp_error) {
            return new WP_Error('empty_receiver', __('Receiver is empty.'));
        } else {
            return 0;
        }
    }

    $post_status = empty($message_arr['post_status']) ? 'unread' : $message_arr['post_status'];
    /*
     * Create a valid post name. Drafts and pending posts are allowed to have
     * an empty post name.
     */
    if (empty($post_name)) {
        if (!in_array($post_status, array('draft', 'pending', 'auto-draft'))) {
            $post_name = sanitize_title($post_title);
        } else {
            $post_name = '';
        }
    } else {
        // On updates, we need to check to see if it's using the old, fixed sanitization context.
        $check_name = sanitize_title($post_name, '', 'old-save');
        if ($update && strtolower(urlencode($post_name)) == $check_name && get_post_field('post_name', $post_ID) == $check_name) {
            $post_name = $check_name;
        } else {
            // new post, or slug has changed.
            $post_name = sanitize_title($post_name);
        }
    }

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
        do_action('pre_post_update', $message_ID, $data);
        if (false === $wpdb->update($message_table, $data, $where)) {
            if ($wp_error) {
                return new WP_Error('db_update_error', __('Could not update post in the database'), $wpdb->last_error);
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
                return new WP_Error('db_insert_error', __('Could not insert post into the database'), $wpdb->last_error);
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
         * @param WP_Post $post         Message object.
         */
        do_action('edit_message', $message_ID, $message);
        $message_after = me_get_message($message_ID);

        /**
         * Fires once an existing message has been updated.
         *
         * @since 1.0
         *
         * @param int     $message_ID      Message ID.
         * @param WP_Post $message_after   Message object following the update.
         * @param WP_Post $message_before  Message object before the update.
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
     * @param WP_Post $message    message object.
     * @param bool    $update  Whether this is an existing message being updated or not.
     */
    do_action("save_message_{$message->post_type}", $message_ID, $message, $update);

    /**
     * Fires once a message has been saved.
     *
     * @since 1.0
     *
     * @param int     $message_ID message ID.
     * @param WP_Post $message    message object.
     * @param bool    $update  Whether this is an existing message being updated or not.
     */
    do_action('save_message', $message_ID, $message, $update);

    /**
     * Fires once a message has been saved.
     *
     * @since 1.0
     *
     * @param int     $message_ID message ID.
     * @param WP_Post $message    message object.
     * @param bool    $update  Whether this is an existing message being updated or not.
     */
    do_action('me_insert_message', $message_ID, $message, $update);

    return $message_ID;
}

/**
 *
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

function me_get_message_status_list() {
    return apply_filters('me_message_status_list', array(
        'sent' => __("Sent", "enginethemes"),
        'read' => __("Seen", "enginethemes"),
    ));
}

function me_get_messages() {

}

function me_get_message() {

}

function me_get_message_field($field, $message = null, $context = 'display') {
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

me_add_message_meta