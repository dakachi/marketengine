<?php

/**
 * MarketEngine Dispute Form Class
 *
 * @author         EngineThemes
 * @package         Includes/Resolution
 */
class ME_RC_Form
{
    public static function init()
    {
        add_action('wp_loaded', array(__CLASS__, 'dispute'));
        add_action('wp_loaded', array(__CLASS__, 'request_close'));
        add_action('wp_loaded', array(__CLASS__, 'close'));
        add_action('wp_loaded', array(__CLASS__, 'escalate'));
        add_action('wp_loaded', array(__CLASS__, 'resolve'));

        add_action('wp_ajax_me-dispute-debate', array(__CLASS__, 'debate'));
        add_action('wp_ajax_get_messages', array(__CLASS__, 'fetch_messages'));
    }

    public static function dispute()
    {
        if (isset($_POST['me-open-dispute-case']) && isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-open_dispute_case')) {

            $case = ME_RC_Form_Handle::insert($_POST);

            if (is_wp_error($case)) {
                me_wp_error_to_notices($case);
            } else {
                $redirect = me_rc_dispute_link($case);
                wp_redirect($redirect);
                exit;
            }
        }
    }

    public static function request_close()
    {
        if (!empty($_GET['request-close']) && !empty($_GET['wpnonce']) && wp_verify_nonce($_GET['wpnonce'], 'me-request_close_dispute')) {
            $case = ME_RC_Form_Handle::request_close($_GET['request-close']);
            if (is_wp_error($case)) {
                me_wp_error_to_notices($case);
            }
            wp_redirect(me_rc_dispute_link($_GET['request-close']));
            exit;
        }
    }

    public static function close()
    {
        if (!empty($_GET['close']) && !empty($_GET['wpnonce']) && wp_verify_nonce($_GET['wpnonce'], 'me-close_dispute')) {
            $case = ME_RC_Form_Handle::close($_GET['close']);
            if (is_wp_error($case)) {
                me_wp_error_to_notices($case);
                wp_redirect(me_rc_dispute_link($_GET['close']));
                exit;
            } else {
                wp_redirect(me_rc_dispute_link($case));
                exit;
            }
        }
    }

    public static function escalate()
    {
        if (!empty($_GET['close']) && !empty($_GET['wpnonce']) && wp_verify_nonce($_GET['wpnonce'], 'me-escalate_dispute')) {
            $case = ME_RC_Form_Handle::close($_GET['escalate']);
            if (is_wp_error($case)) {
                me_wp_error_to_notices($case);
            }
            wp_redirect(me_rc_dispute_link($_GET['escalate']));
            exit;
        }
    }

    public static function resolve()
    {

    }

    public static function debate() {
        if (!empty($_POST['dispute']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-debate')) {
            $message = ME_RC_Form_Handle::debate($_POST);
            if (!is_wp_error($case)) {
                $message = me_get_message($message);
                ob_start();
                me_get_template('resolution/message-item', array('message' => $message)); 
                $content = ob_get_clean();
                wp_send_json(array('success' => true, 'html' => $content));
            }else {
                wp_send_json( array('success' => false) );
            }
        }
    }

    /**
     * User fetch the older messages
     */
    public static function fetch_messages()
    {
        if (!empty($_GET['parent']) && !empty($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'me-debate')) {
            $parent  = me_get_message($_GET['parent']);
            $user_id = get_current_user_id();
            if ($parent->receiver != $user_id && $parent->sender != $user_id) {
                wp_send_json(array('success' => false));
            }
            $messages = me_get_messages(array('post_type' => array('message', 'revision'), 'showposts' => 12, 'post_parent' => $parent->ID, 'paged' => $_GET['paged']));
            $messages = array_reverse($messages);
            ob_start();
            foreach ($messages as $key => $message) {
                me_get_template('resolution/'.$message->post_type.'-item', array('message' => $message));
            }
            $content = ob_get_clean();

            wp_send_json(array('success' => true, 'data' => $content));
        }
    }
}
