<?php
class ME_Shortcodes_Auth {
    public static function init_shortcodes() {
        add_shortcode('me_user_account', array(__CLASS__, 'me_user_account'));
        add_shortcode('me_user_register', array(__CLASS__, 'me_register_form'));
    }
    public static function me_user_account() {
        global $wp;
        if (isset($wp->query_vars['forgot-password'])) {
            return self::forgot_password_form();
        } else {
            return self::me_login_form();
        }
    }
    public static function me_login_form() {
        ob_start();
        me_get_template_part('account/form-login');
        $content = ob_get_clean();
        return $content;
    }

    public static function me_register_form() {
        ob_start();
        me_get_template_part('account/form-register');
        $content = ob_get_clean();
        return $content;
    }

    public static function forgot_password_form() {
        ob_start();
        me_get_template_part('account/forgot-password');
        $content = ob_get_clean();
        return $content;
    }
}
ME_Shortcodes_Auth::init_shortcodes();