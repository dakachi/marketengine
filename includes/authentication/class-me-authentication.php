<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ME_Authentication
 *
 * Handling visitor authentication behavior
 *
 * @class       ME_Authentication
 * @version     1.0
 * @package     MarketEngine/Includes
 * @author      EngineThemesTeam
 * @category    Class
 */
class ME_Authentication {
    /**
     * Login
     *
     * Signon a user into system
     *
     * @since 1.0
     *
     * @see wp_signon
     * @param array $user_data
     *     @type string      $user_pass            The plain-text user password.
     *     @type string      $user_login           The user's login username.
     *
     * @return WP_User|WP_Error True: WP_User finish. WP_Error on error
     */
    public static function login($user_data) {
        $user_login = $user_data['user_login'];
        $user_pass = $user_data['user_password'];

        $error = new WP_Error();
        if (empty($user_login)) {
            $error->add('username_required', __('The field username is required.', 'enginethemes'));
        }
        if (empty($user_pass)) {
            $error->add('password_required', __('The field password is required.', 'enginethemes'));
        }
        if ($error->get_error_messages()) {
            return $error;
        }

        $user = get_user_by('login', $user_login);
        if (!$user && strpos($user_login, '@')) {
            $user = get_user_by('email', $user_login);
        }

        if ($user) {
            $user_login = $user->user_login;
        }

        $creds = array();
        $creds['user_login'] = $user_login;
        $creds['user_password'] = $user_pass;
        $creds['remember'] = isset($user_data['rememberme']);
        $secure = is_ssl() ? true : false;
        /**
         * filter the login credentials
         * @param Array $creds
         * @since 1.0
         */
        $creds = apply_filters('marketengine_login_credentials', $creds);
        $user = wp_signon($creds, $secure);

        return $user;
    }
    /**
     * Register new user
     *
     * Add new user to the blog
     *
     * @since 1.0
     *
     * @see wp_insert_user
     * @param Array $user_data The user info
     *     @type string      $user_pass            The plain-text user password.
     *     @type string      $user_login           The user's login username.
     *     @type email       $user_email           The user's email.
     *
     * @return WP_User|WP_Error True: WP_User finish. WP_Error on error
     */
    public static function register($user_data) {
        // TODO: these rules will be considered, role?
        $rules = array(
            'user_login' => 'required',
            'user_pass' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'confirm_pass' => 'required|same:user_pass',
            'user_email' => 'required|email',
            'agree_with_tos' => 'required',
        );

        /**
         * Filter register data validate rules
         *
         * @param Array $rules
         * @param Array $user_data
         *
         * @since 1.0
         */
        $rules = apply_filters('marketengine_register_form_rules', $rules, $user_data);
        $is_valid = me_validate($user_data, $rules);

        $errors = new WP_Error();
        if (!$is_valid) {
            $invalid_data = me_get_invalid_message($user_data, $rules);
            foreach ($invalid_data as $key => $message) {
                $errors->add($key, $message);
            }
            return $errors;
        }

        extract($user_data);
        $sanitized_user_login = sanitize_user($user_login);
        /**
         * Filter the email address of a user being registered.
         *
         * @since 1.0
         *
         * @param string $user_email The email address of the new user.
         */
        $user_email = apply_filters('user_registration_email', $user_email);

        // Check the username
        if ($sanitized_user_login == '') {
            $errors->add('empty_username', __("Please enter a username.", "enginethemes"));
        } elseif (!validate_username($user_login) || preg_match('/[^a-z0-9]/', $user_data['user_login'])) {
            $errors->add('invalid_username', __("Usernames can only contain letters (a-z), numbers (0-9), and underscores (_).", "enginethemes"));
            $sanitized_user_login = '';
        } else {
            /** This filter is documented in wp-includes/user.php */
            $illegal_user_logins = array_map('strtolower', (array) apply_filters('illegal_user_logins', array()));
            if (in_array(strtolower($sanitized_user_login), $illegal_user_logins)) {
                $errors->add('invalid_username', __("Sorry, that username is not allowed.", "enginethemes"));
            }
        }

        // Check the email address
        if ($user_email == '') {
            $errors->add('empty_email', __("Please type your email address.", "enginethemes"));
        } elseif (!is_email($user_email)) {
            $errors->add('invalid_email', __("The email address isn&#8217;t correct.", "enginethemes"));
            $user_email = '';
        }

        /**
         * Fires when submitting registration form data, before the user is created.
         *
         * @since 1.0
         *
         * @param string   $sanitized_user_login The submitted username after being sanitized.
         * @param string   $user_email           The submitted email.
         * @param WP_Error $errors               Contains any errors with submitted username and email,
         *                                       e.g., an empty field, an invalid username or email,
         *                                       or an existing username or email.
         */
        do_action('register_post', $sanitized_user_login, $user_email, $errors);

        /**
         * Filter the errors encountered when a new user is being registered.
         *
         * The filtered WP_Error object may, for example, contain errors for an invalid
         * or existing username or email address. A WP_Error object should always returned,
         * but may or may not contain errors.
         *
         * If any errors are present in $errors, this will abort the user's registration.
         *
         * @since 1.0
         *
         * @param WP_Error $errors               A WP_Error object containing any errors encountered
         *                                       during registration.
         * @param string   $sanitized_user_login User's username after it has been sanitized.
         * @param string   $user_email           User's email.
         */
        $errors = apply_filters('registration_errors', $errors, $sanitized_user_login, $user_email);

        if ($errors->get_error_code()) {
            return $errors;
        }

        /**
         * do action before add new user
         *
         * @param Array $user_data The data user submit
         *
         * @since 1.0
         */
        do_action('marketengine_before_user_register', $user_data);

        $user_id = wp_insert_user($user_data);
        if (is_wp_error($user_id)) {
            return $user_id;
        }

        $user = new WP_User($user_id);
        if (get_option('is_required_email_confirmation')) {
            // generate the activation key
            $activate_email_key = wp_hash(md5($user_data['user_email'] . time()));
            // store the activation key to user meta data
            update_user_meta($user->ID, 'activate_email_key', $activate_email_key);
            // send email
            self::send_activation_email($user);
        } else {
            self::send_registration_success_email($user);
        }
        /**
         * Do action me_user_register
         *
         * @param Object $user WP_User
         * @param Array $user_data
         *
         * @since 1.0
         *
         */
        do_action('marketengine_user_register', $user, $user_data);
        // TODO: send confirm email
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
    public static function retrieve_password($user) {
        global $wpdb, $wp_hasher;

        $errors = new WP_Error();

        $rules = array(
            'user_email' => 'required|email',
        );

        /**
         * Filter register data validate rules
         *
         * @param Array $rules
         * @param Array $user
         *
         * @since 1.0
         */
        $rules = apply_filters('marketengine_forgot_password_form_rules', $rules, $user);
        $is_valid = me_validate($user, $rules);

        if (!$is_valid) {
            $invalid_data = me_get_invalid_message($user, $rules);
            foreach ($invalid_data as $key => $message) {
                $errors->add($key, $message);
            }
            return $errors;
        }

        $user_data = get_user_by('email', trim($user['user_login']));
        if (empty($user_data)) {
            $errors->add('invalid_email', __("<strong>ERROR</strong>: There is no user registered with that email address.", "enginethemes"));
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
        do_action('lostpassword_post', $errors);

        if ($errors->get_error_code()) {
            return $errors;
        }

        if (!$user_data) {
            $errors->add('invalidcombo', __("<strong>ERROR</strong>: Invalid email.", "enginethemes"));
            return $errors;
        }

        // Redefining user_login ensures we return the right case in the email.
        $user_login = $user_data->user_login;
        $user_email = $user_data->user_email;
        $key = get_password_reset_key($user_data);

        if (is_wp_error($key)) {
            return $key;
        }

        $profile_link = me_get_page_permalink('user-profile');
        $reset_pass_link = add_query_arg(array(
            'key' => $key,
            'login' => rawurlencode($user_login),
        ), me_get_endpoint_url('reset-password', '', $profile_link));

        $reset_pass_link = apply_filters('marketengine_resert_password_link', $reset_pass_link, $user_data, $key);


        ob_start();
        me_get_template_part('emails/reset-password');
        $message = ob_get_clean();

        if (is_multisite()) {
            $blogname = $GLOBALS['current_site']->site_name;
        } else
        /*
         * The blogname option is escaped with esc_html on the way into the database
         * in sanitize_option we want to reverse this for the plain text arena of emails.
         */
        {
            $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
        }

        $title = sprintf(__("[%s] Password Reset", "enginethemes"), $blogname);

        /**
         * Filter user reset password email subject
         *
         * @param String $mail_subject
         * @param Object $user_data
         *
         * @since 1.0
         */
        $title = apply_filters('marketengine_reset_password_mail_subject', $title, $user_data);

        $message = str_replace('[recover_url]', $reset_pass_link, $message);
        /**
         * Filter user reset password email content
         *
         * @param String $mail_content
         * @param Object $user_data
         *
         * @since 1.0
         */
        $message = apply_filters('marketengine_reset_password_mail_content', $message, $user_data);

        if ($message && !wp_mail($user_email, wp_specialchars_decode($title), $message)) {
            return new WP_Error('system_error', __('The email could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function.', "enginethemes"));
        }

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
    public static function reset_pass($user_data) {
        $rules = array(
            'user_login' => 'required',
            'new_pass' => 'required',
            'confirm_pass' => 'required|same:new_pass',
            'key' => 'required',
        );
        /**
         * filter reset pass data validate rules
         *
         * @param Array $rules
         * @param Array $user_data
         *
         * @since 1.0
         */
        $rules = apply_filters('marketengine_reset_password_form_rules', $rules, $user_data);
        $is_valid = me_validate($user_data, $rules);
        if (!$is_valid) {
            $errors = new WP_Error();
            $invalid_data = me_get_invalid_message($user_data, $rules);
            foreach ($invalid_data as $key => $message) {
                $errors->add($key, $message);
            }
            return $errors;
        }

        $user = check_password_reset_key($user_data['key'], $user_data['user_login']);
        if (is_wp_error($user)) {
            return $user;
        } else {
            do_action('password_reset', $user, $user_data['new_pass']);
            wp_set_password($user_data['new_pass'], $user->ID);
            return $user;
        }
    }
    /**
     * User Confirm Email
     *
     * Check the confirm key and set the user account is confirmed
     *
     * @since 1.0
     *
     * @param Array $user_data The confirm info
     *         - Email user_email  : the email need to confirm
     *         - String key:    the secure key
     * @return WP_Error| WP_User object
     */
    public static function confirm_email($user_data) {
        $rules = array(
            'user_email' => 'required|email',
            'key' => 'required',
        );
        /**
         * filter confirm email data validate rules
         *
         * @param Array $rules
         * @param Array $user_data
         *
         * @since 1.0
         */
        $rules = apply_filters('marketengine_confirm_mail_rules', $rules, $user_data);
        $is_valid = me_validate($user_data, $rules);
        if (!$is_valid) {
            $errors = new WP_Error();
            $invalid_data = me_get_invalid_message($user_data, $rules);
            foreach ($invalid_data as $key => $message) {
                $errors->add($key, $message);
            }
            return $errors;
        }

        $user = get_user_by('email', $user_data['user_email']);
        if (!$user) {
            return new WP_Error('email_not_exists', __("The email is not exists.", "enginethemes"));
        }

        $activate_email_key = get_user_meta($user->ID, 'activate_email_key', true);
        if ($activate_email_key && $activate_email_key !== $user_data['key']) {
            return new WP_Error('invalid_key', __("Invalid key.", "enginethemes"));
        }
        delete_user_meta($user->ID, 'activate_email_key');
        /**
         * Do action after user confirmed email
         *
         * @param Object $user
         *
         * @since 1.0
         */
        do_action('marketengine_user_confirm_email', $user);
        return $user;
    }

    /**
     * Send Activation Email
     *
     * Send activation email to user with activation link
     *
     * @since 1.0
     *
     * @param WP_User $user
     *
     * @return bool | WP_Error
     */
    public static function send_activation_email($user) {
        $user_activate_email_key = get_user_meta($user->ID, 'activate_email_key', true);
        if ($user_activate_email_key) {
            // get activation mail content from template
            ob_start();
            me_get_template_part('emails/activation');
            $activation_mail_content = ob_get_clean();
            /**
             * Filter user activation email subject
             *
             * @param String $mail_subject
             * @param Object $user
             *
             * @since 1.0
             */
            $activation_mail_subject = apply_filters('marketengine_activation_mail_subject', __("Activate Email", "enginethemes"), $user);
            $profile_link = me_get_page_permalink('user-profile');
            $activate_email_link = add_query_arg(array(
                'key' => $user_activate_email_key,
                'user_email' => $user->user_email,
                'action' => 'confirm-email',
            ), $profile_link);

            $activation_mail_content = str_replace('[activate_email_link]', $activate_email_link, $activation_mail_content);
            /**
             * Filter user activation email content
             *
             * @param String $mail_content
             * @param Object $user
             *
             * @since 1.0
             */
            $activation_mail_content = apply_filters('marketengine_activation_mail_content', $activation_mail_content, $user);

            return wp_mail($user->user_email, $activation_mail_subject, $activation_mail_content);
        } else {
            return new WP_Error('already_confirmed', __("Your email is already confirmed.", "enginethemes"));
        }
    }

    /**
     * Send Registration Success Email
     *
     * @since 1.0
     *
     * @param WP_User $user
     *
     * @return bool
     */
    public static function send_registration_success_email($user) {
        // get registration success mail content from template
        ob_start();
        me_get_template_part('emails/registration-success');
        $registration_success_mail_content = ob_get_clean();
        /**
         * Filter user registration success email subject
         *
         * @param String $registration_success_mail_content
         * @param WP_User $user
         *
         * @since 1.0
         */
        $registration_success_mail_subject = apply_filters('marketengine_registration_success_email_subject', __("Registration Success Email", "enginethemes"), $user);
        /**
         * Filter user registration success email content
         *
         * @param String $registration_success_mail_subject
         * @param WP_User $user
         *
         * @since 1.0
         */
        $registration_success_mail_content = apply_filters('marketengine_registration_success_mail_content', $registration_success_mail_content, $user);

        return wp_mail($user->user_email, $registration_success_mail_subject, $registration_success_mail_content);
    }

    /**
     * Update user profile info
     *
     * @since 1.0
     *
     * @see wp_insert_user() More complete way to create a new user
     *
     * @param Array $user_data
     *
     * @return Int | WP_Error
     */
    public static function update_profile($user_data) {
        global $user_ID;
        $user_id = $user_ID;

        if (current_user_can('edit_users') && isset($user_data['ID'])) {
            $user_id = $user_data['ID'];
        }

        $user_data['ID'] = $user_id;

        /**
         * Filter list fields user can not change
         *
         * @param Array
         *
         * @since 1.0
         */
        $non_editable_fields = apply_filters('marketengine_profile_non_editable_fields', array(
            'user_login' => __("User Login", "enginethemes"),
            'user_email' => __("User email", "enginethemes"),
        )
        );
        $user_data = array_diff_key($user_data, $non_editable_fields);
        return wp_update_user($user_data);
    }
}

function me_add_user_meta($meta) {
    if (isset($_POST['location'])) {
        $meta['location'] = $_POST['location'];
    }
    return $meta;
}
add_filter('insert_user_meta', 'me_add_user_meta');