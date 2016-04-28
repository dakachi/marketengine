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
    /**
     * The single instance of the class.
     *
     * @var ME_Auth_Form
     * @since 1.0
     */
    protected static $_instance = null;

    /**
     * Main ME_Auth_Form Instance.
     *
     * Ensures only one instance of ME_Auth_Form is loaded or can be loaded.
     *
     * @since 1.0
     * @return ME_Auth_Form - Main instance.
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {

    }

    public function add_action() {
        add_action( 'wp_loaded', array( &$this, 'process_login' ) );
        add_action( 'wp_loaded', array( &$this, 'process_register' ) );
        add_action( 'wp_loaded', array( &$this, 'process_forgot_pass' ) );
        add_action( 'wp_loaded', array( &$this, 'process_reset_pass' ) );
        add_action( 'wp_loaded', array( &$this, 'process_activate_email' ) );
    }

    public function process_login() {
        if ( ! empty( $_POST['login'] ) && ! empty( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'me-login' ) ) {
            $user = ME()->user->login( $_POST );
            if ( is_wp_error( $user ) ) {
                $message = $user->get_error_message();
                me_add_notice($message, 'error');
            }else {
                // set the redirect link after login
                if(isset($_POST['redirect'])) {
                    $redirect = $_POST['redirect'];
                } elseif ( wp_get_referer() ) {
                    $redirect = wp_get_referer();
                } else {
                    $redirect = me_get_page_permalink( 'my_profile' );
                }
                /**
                 * action filter redirect link after user login
                 * @param String $redirect
                 * @param Object $user User object
                 * @since 1.0
                 * @author EngineTeam
                 */
                $redirect = apply_filters( 'me_login_redirect', $redirect, $user );
                wp_redirect( $redirect, 302 );
                exit;
            }
        }
    }

    public function process_register() {
        if ( ! empty( $_POST['register'] ) && ! empty( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'me-register' ) ) {
            $user = ME()->user->register( $_POST );
            if ( is_wp_error( $user ) ) {
                $message = $user->get_error_message();
                me_add_notice($message, 'error');
            }else {
                // set the redirect link after login
                if(isset($_POST['redirect'])) {
                    $redirect = $_POST['redirect'];
                } elseif ( wp_get_referer() ) {
                    $redirect = wp_get_referer();
                } else {
                    $redirect = me_get_page_permalink( 'my_profile' );
                }
                /**
                 * action filter redirect link after user login
                 * @param String $redirect
                 * @param Object $user User object
                 * @since 1.0
                 * @author EngineTeam
                 */
                $redirect = apply_filters( 'me_register_redirect', $redirect, $user );
                wp_redirect( $redirect, 302 );
                exit;
            }
        }
    }

    public function process_forgot_pass() {
        if ( ! empty( $_POST['forgot_pass'] ) && ! empty( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'me-forgot_pass' ) ) {
            $password_retrieve = ME()->user->retrieve_password( $_POST );
            if( $password_retrieve ) {
                 // set the redirect link after login
                if(isset($_POST['redirect'])) {
                    $redirect = $_POST['redirect'];
                } elseif ( wp_get_referer() ) {
                    $redirect = wp_get_referer();
                } else {
                    $redirect = me_get_page_permalink( 'retrieve_password_success' );
                }
                /**
                 * action filter redirect link after user login
                 * @param String $redirect
                 * @param Object $user User object
                 * @since 1.0
                 * @author EngineTeam
                 */
                $redirect = apply_filters( 'me_retrieve_password_redirect', $redirect, $user );
                wp_redirect( $redirect, 302 );
                exit;
            }else {
                $message = $password_retrieve->get_error_message();
                me_add_notice($message, 'error');
            }
        }
    }

    public function process_reset_pass() {
        if ( ! empty( $_POST['reset_password'] ) && ! empty( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'me-reset_password' ) ) {
            $user = ME()->user->reset_pass( $_POST );
            if( $user ) {
                 // set the redirect link after login
                if(isset($_POST['redirect'])) {
                    $redirect = $_POST['redirect'];
                } elseif ( wp_get_referer() ) {
                    $redirect = wp_get_referer();
                } else {
                    $redirect = me_get_page_permalink( 'me_reset_password_redirect' );
                }
                /**
                 * action filter redirect link after user login
                 * @param String $redirect
                 * @param Object $user User object
                 * @since 1.0
                 * @author EngineTeam
                 */
                $redirect = apply_filters( 'me_reset_password_redirect', $redirect, $user );
                wp_redirect( $redirect, 302 );
                exit;
            }else {
                $message = $user->get_error_message();
                me_add_notice($message, 'error');
            }
        }
    }

    public function process_confirm_email() {

    }
}