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
        if (!empty($_GET['request-close']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-request_close_dispute')) {
            $case = ME_RC_Form_Handle::request_close($_POST['request-close']);
            if (is_wp_error($case)) {
                me_wp_error_to_notices($case);
            } else {
                wp_redirect(me_rc_dispute_link($case));
                exit;
            }
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

    public static function escalate($dispute_id)
    {

    }

    public static function resolve($dispute_id)
    {

    }
}
