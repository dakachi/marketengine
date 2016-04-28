<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class ME_User {
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

	public function login( $user_data ) {
        $user_login = trim( $user_data['user_login'] );
        $user_pass = $user_data['user_password'];

        if( empty( $user_login ) ) {
            return new WP_Error( 'username_required', __('Username is required.', 'enginethemes') );
        }
        if( empty( $user_pass ) ) {
            return new WP_Error( 'password_required', __('Password is required.', 'enginethemes') );
        }
        $creds                  = array();
        $creds['user_login']    = $user_login;
        $creds['user_password'] = $user_pass;
        $creds['remember']      = isset( $user_data['rememberme'] );
        $secure = is_ssl() ? true : false;
        /**
         * filter the login credentials
         * @param Array $creds
         * @since 1.0
         */
        $creds = apply_filters( 'me_login_credentials', $creds );
        $user = wp_signon( $creds, $secure );
        return $user;
    }

    public function register( $user_data ) {
        // TODO: these rules will be considered
        $rules = array(
            'user_login' => 'required',
            'user_pass' => 'required',
            'user_email' => 'required|email',
            'agree_with_tos' => 'required'
        );
        /**
         * filter register data validate rules
         *
         * @param Array $rules
         * @param Array $user_data
         *
         * @since 1.0
         */
        $rules = apply_filters( 'me_register_rules', $rules, $user_data );
        $is_valid = me_validate( $user_data, $rules );
        if( ! $is_valid ) {
            $errors = new WP_Error();
            $invalid_data = me_get_invalid_message( $user_data, $rules );
            foreach( $invalid_data as $key => $message ) {
                $errors->add( $key, $message );
            }
            return $errors;
        }
        $user = wp_insert_user( $user_data );
        return $user;
    }

    /**
     * This function copy from wordpress wp-login.php
     *
     * Handles sending password retrieval email to user.
     *
     * @global wpdb         $wpdb      WordPress database abstraction object.
     * @global PasswordHash $wp_hasher Portable PHP password hashing framework.
     *
     * @return bool|WP_Error True: when finish. WP_Error on error
     */
    public function retrieve_password( $user ) {
        global $wpdb, $wp_hasher;

        $errors = new WP_Error();

        if ( empty( $user['user_login'] ) ) {
            $errors->add('empty_username', __( "<strong>ERROR</strong>: Enter a username or email address." , "enginethemes" ));
        } elseif ( strpos( $user['user_login'], '@' ) ) {
            $user_data = get_user_by( 'email', trim( $user['user_login'] ) );
            if ( empty( $user_data ) )
                $errors->add('invalid_email', __( "<strong>ERROR</strong>: There is no user registered with that email address." , "enginethemes" ));
        } else {
            $login = trim($user['user_login']);
            $user_data = get_user_by('login', $login);
        }

        /**
         * Fires before errors are returned from a password reset request.
         *
         * @since 2.1.0
         * @since 4.4.0 Added the `$errors` parameter.
         *
         * @param WP_Error $errors A WP_Error object containing any errors generated
         *                         by using invalid credentials.
         */
        do_action( 'lostpassword_post', $errors );

        if ( $errors->get_error_code() )
            return $errors;

        if ( !$user_data ) {
            $errors->add('invalidcombo', __( "<strong>ERROR</strong>: Invalid username or email." , "enginethemes" ));
            return $errors;
        }

        // Redefining user_login ensures we return the right case in the email.
        $user_login = $user_data->user_login;
        $user_email = $user_data->user_email;
        $key = get_password_reset_key( $user_data );

        if ( is_wp_error( $key ) ) {
            return $key;
        }
        // TODO: update message
        $message = __( "Someone has requested a password reset for the following account:" , "enginethemes" ) . "\r\n\r\n";
        $message .= network_home_url( '/' ) . "\r\n\r\n";
        $message .= sprintf(__( "Username: %s" , "enginethemes" ), $user_login) . "\r\n\r\n";
        $message .= __( "If this was a mistake, just ignore this email and nothing will happen." , "enginethemes" ) . "\r\n\r\n";
        $message .= __( "To reset your password, visit the following address:" , "enginethemes" ) . "\r\n\r\n";
        $message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

        if ( is_multisite() )
            $blogname = $GLOBALS['current_site']->site_name;
        else
            /*
             * The blogname option is escaped with esc_html on the way into the database
             * in sanitize_option we want to reverse this for the plain text arena of emails.
             */
            $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

        $title = sprintf( __( "[%s] Password Reset" , "enginethemes" ), $blogname );

        /**
         * Filter the subject of the password reset email.
         *
         * @since 2.8.0
         * @since 4.4.0 Added the `$user_login` and `$user_data` parameters.
         *
         * @param string  $title      Default email title.
         * @param string  $user_login The username for the user.
         * @param WP_User $user_data  WP_User object.
         */
        $title = apply_filters( 'retrieve_password_title', $title, $user_login, $user_data );

        /**
         * Filter the message body of the password reset mail.
         *
         * @since 2.8.0
         * @since 4.1.0 Added `$user_login` and `$user_data` parameters.
         *
         * @param string  $message    Default mail message.
         * @param string  $key        The activation key.
         * @param string  $user_login The username for the user.
         * @param WP_User $user_data  WP_User object.
         */
        $message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );

        if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) )
            return new WP_Error( 'system_error', __( 'The email could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function.' , "enginethemes" ) );

        return true;
    }

    /**
     * Reset user password
     *
     * Check the activation key and reset user pass
     *
     * @since 1.0
     *
     * @see reset_password()
     * @param Array  $user_data The user reset pass data
     * @return WP_User| WP_Error WP_User: when finish. WP_Error on error
     */
    public function reset_pass( $user_data ) {
        $rules = array(
            'user_login' => 'required',
            'new_pass' => 'required',
            'retype_pass' =>  'required|same:new_pass',
            'key' => 'required'
        );
        /**
         * filter reset pass data validate rules
         *
         * @param Array $rules
         * @param Array $user_data
         *
         * @since 1.0
         */
        $rules = apply_filters( 'me_reset_pass_rules', $rules, $user_data );
        $is_valid = me_validate( $user_data, $rules );
        if( ! $is_valid ) {
            $errors = new WP_Error();
            $invalid_data = me_get_invalid_message( $user_data, $rules );
            foreach( $invalid_data as $key => $message ) {
                $errors->add( $key, $message );
            }
            return $errors;
        }

        $user = check_password_reset_key( $user_data['key'], $user_data['user_login'] );
        if( is_wp_error( $user ) ) {
            return $user;
        } else {
            reset_password( $user, $user_data['new_pass'] );
            return $user;
        }
    }
}