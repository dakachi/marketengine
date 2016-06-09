<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ME Authentication Form
 *
 * Class control user data in authentication form
 *
 * @version     1.0
 * @package     Includes/Authentication
 * @author      Dakachi
 * @category    Class
 */
class ME_Auth_Form extends ME_Form {

    public static function init_hooks() {
        add_action('wp_loaded', array(__CLASS__, 'process_login'));
        add_action('wp_loaded', array(__CLASS__, 'process_register'));
        add_action('wp_loaded', array(__CLASS__, 'process_forgot_pass'));
        add_action('wp_loaded', array(__CLASS__, 'process_reset_pass'));
        add_action('wp_loaded', array(__CLASS__, 'process_confirm_email'));
        add_action('wp_loaded', array(__CLASS__, 'process_resend_confirm_email'));

        add_action('wp_loaded', array(__CLASS__, 'process_change_password'));
        add_action('wp_loaded', array(__CLASS__, 'update_user_profile'));
    }

    public static function get_redirect_link() {
        if (isset($_POST['redirect'])) {
            $redirect = $_POST['redirect'];
        } elseif (wp_get_referer()) {
            $redirect = wp_get_referer();
        } else {
            $redirect = me_get_page_permalink('user-profile');
        }
        return $redirect;
    }

    public static function process_login() {
        if (!empty($_POST['login']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-login')) {
            $user = ME_Authentication::login($_POST);
            if (is_wp_error($user)) {
                me_wp_error_to_notices($user);
            } else {
                // set the redirect link after login
                if (isset($_POST['redirect'])) {
                    $redirect = $_POST['redirect'];
                } elseif (wp_get_referer()) {
                    $redirect = wp_get_referer();
                } else {
                    $redirect = home_url();
                }
                /**
                 * action filter redirect link after user login
                 * @param String $redirect
                 * @param Object $user User object
                 * @since 1.0
                 * @author EngineTeam
                 */
                $redirect = apply_filters('marketengine_login_redirect', $redirect, $user);
                wp_redirect($redirect, 302);
                exit;
            }
        }
    }

    public static function process_register() {
        if (!empty($_POST['register']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-register')) {
            // Admin disable registration function
            if (!get_option('users_can_register')) {
                wp_redirect(site_url('wp-login.php?registration=disabled'));
                exit();
            }

            $user = ME_Authentication::register($_POST);
            if (is_wp_error($user)) {
                me_wp_error_to_notices($user);
                return false;
            }

            if (get_option('is_required_email_confirmation')) {
                me_add_notice(__("You have registered successfully. Please check your mailbox to activate your account", "enginethemes"));
            } else {
                me_add_notice(__("You have registered successfully.", "enginethemes"));
            }
            // login in
            $_POST['user_password'] = $_POST['user_pass'];
            $user = ME_Authentication::login($_POST);
            // set the redirect link after register
            $redirect = self::get_redirect_link();
            /**
             * action filter redirect link after user login
             * @param String $redirect
             * @param Object $user User object
             * @since 1.0
             * @author EngineTeam
             */
            $redirect = apply_filters('marketengine_register_redirect', $redirect, $user);
            wp_redirect($redirect, 302);
            exit;
        }
    }

    public static function process_forgot_pass() {
        if (!empty($_POST['forgot_pass']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-forgot_pass')) {
            $password_retrieve = ME_Authentication::retrieve_password($_POST);
            if (!is_wp_error($password_retrieve)) {
                me_add_notice(__("The reset password email aldready send to your email account.", "enginethemes"));
                // set the redirect link after forgot pass
                $redirect = self::get_redirect_link();
                /**
                 * action filter redirect link after user login
                 * @param String $redirect
                 * @param Object $user User object
                 * @since 1.0
                 * @author EngineTeam
                 */
                $redirect = apply_filters('marketengine_retrieve_password_redirect', $redirect, $user);
                wp_redirect($redirect, 302);
                exit;
            } else {
                me_wp_error_to_notices($password_retrieve);
            }
        }
    }

    public static function process_reset_pass() {
        if (!empty($_POST['reset_password']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-reset_password')) {
            $user = ME_Authentication::reset_pass($_POST);
            if (!is_wp_error($user)) {
                me_add_notice(__("You have reset your password. Now you can login by your new password.", "enginethemes"));
                // set the redirect link after reset pass
                $redirect = self::get_redirect_link();
                /**
                 * action filter redirect link after user login
                 * @param String $redirect
                 * @param Object $user User object
                 * @since 1.0
                 * @author EngineTeam
                 */
                $redirect = apply_filters('marketengine_reset_password_redirect', $redirect, $user);
                wp_redirect($redirect, 302);
                exit;
            } else {
                me_wp_error_to_notices($user);
            }
        }
    }

    public static function process_confirm_email() {
        if (!empty($_GET['action']) && 'confirm-email' === $_GET['action']) {
            $user = ME_Authentication::confirm_email($_GET);
            if (!is_wp_error($user)) {
                me_add_notice(__("Your account has been confirmed successfully!.", "enginethemes"));
                // set the redirect link after confirm email
                $redirect = self::get_redirect_link();
                /**
                 * action filter redirect link after user login
                 * @param String $redirect
                 * @param Object $user User object
                 * @since 1.0
                 * @author EngineTeam
                 */
                $redirect = apply_filters('marketengine_reset_password_redirect', $redirect, $user);
                wp_redirect($redirect, 302);
                exit;
            } else {
                me_wp_error_to_notices($user);
            }
        }
    }

    public static function process_resend_confirm_email() {
        if (!empty($_GET['resend-confirmation-email']) && !empty($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'me-resend_confirmation_email')) {
            global $current_user;
            $is_send_success = ME_Authentication::send_activation_email($current_user);
            if (!is_wp_error($is_send_success)) {
                // set the redirect link after ask confirm email
                $redirect = self::get_redirect_link();
                $redirect = apply_filters('marketengine_resend_confirm_email_redirect', $redirect, $current_user);
                wp_redirect($redirect, 302);
                exit;
            } else {
                me_wp_error_to_notices($is_send_success);
            }
        }
    }

    public static function update_user_profile() {
        if (!empty($_POST['update_profile']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me-update_profile')) {
            $user = ME_Authentication::update_profile($_POST);
            if (!is_wp_error($user)) {
                // set the redirect link after ask confirm email
                $redirect = self::get_redirect_link();
                $redirect = apply_filters('marketengine_update_profile_redirect', $redirect, $user);
                wp_redirect($redirect, 302);
                exit;
            }else {
                me_wp_error_to_notices($user);
            }
        }
    }

    public static function process_change_password(){
        if (!empty($_POST['change_password']) && !empty($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'me_change-password')) {
            $user = ME_Authentication::change_password($_POST);
            if (!is_wp_error($user)) {
                // set the redirect link after ask confirm email
                $redirect = self::get_redirect_link();
                $redirect = apply_filters('marketengine_update_profile_redirect', $redirect, $user);
                wp_redirect($redirect, 302);
                exit;
            }else {
                me_wp_error_to_notices($user);
            }
        }
    }
}

ME_Auth_Form::init_hooks();