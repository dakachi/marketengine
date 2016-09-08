<?php
class ME_Shortcodes_Auth {
    public static function init_shortcodes() {
        add_shortcode('me_user_account', array(__CLASS__, 'me_user_account'));
        add_shortcode('me_user_register', array(__CLASS__, 'me_register_form'));
        add_shortcode('me_user_login', array(__CLASS__, 'me_login_form'));
    }
    public static function me_user_account() {
        global $wp;
        if (is_user_logged_in()) {
            return self::logged_in_template();
        } else {
            return self::authentication_template();
        }
    }
    public static function logged_in_template() {
        if (isset($wp->query_vars['edit-profile'])) {
            return self::me_user_edit_profile();
        } elseif (isset($wp->query_vars['change-password'])) {
            return self::me_change_password();
        } elseif (isset($wp->query_vars['listings'])) {
            return self::me_user_listings();
        }
        return self::me_user_profile();
    }

    public static function authentication_template() {
        if (isset($wp->query_vars['forgot-password'])) {
            return self::forgot_password_form();
        } elseif (isset($wp->query_vars['reset-password'])) {
            return self::me_resetpass_form();
        } elseif (isset($wp->query_vars['register'])) {
            return self::me_register_form();
        }
        return self::me_login_form();
    }
    public static function me_user_profile() {
        ob_start();
        me_get_template('account/user-profile');
        $content = ob_get_clean();
        return $content;
    }

    public static function me_user_edit_profile() {
        ob_start();
        me_get_template('account/edit-profile');
        $content = ob_get_clean();
        return $content;
    }

    public static function me_change_password() {
        ob_start();
        me_get_template('account/change-password');
        $content = ob_get_clean();
        return $content;
    }

    public static function me_user_listings() {
        ob_start();
        me_get_template('account/my-listings');
        $content = ob_get_clean();
        return $content;
    }

    public static function me_login_form() {
        ob_start();
        me_get_template('account/form-login');
        $content = ob_get_clean();
        return $content;
    }
    public static function me_register_form() {
        ob_start();
        me_get_template('account/form-register');
        $content = ob_get_clean();
        return $content;
    }

    public static function forgot_password_form() {
        ob_start();
        me_get_template('account/forgot-password');
        $content = ob_get_clean();
        return $content;
    }
    public static function me_resetpass_form() {
        ob_start();
        me_get_template('account/reset-pass');
        $content = ob_get_clean();
        return $content;
    }
    public static function me_confirm_email() {
        ob_start();
        me_get_template('account/confirm-email');
        $content = ob_get_clean();
        return $content;
    }
}
ME_Shortcodes_Auth::init_shortcodes();