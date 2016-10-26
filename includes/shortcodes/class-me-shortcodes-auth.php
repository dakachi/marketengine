<?php
class ME_Shortcodes_Auth {
    public static function init_shortcodes() {
        add_shortcode('me_user_account', array(__CLASS__, 'me_user_account'));
        add_shortcode('me_user_register', array(__CLASS__, 'me_register_form'));
        add_shortcode('me_user_login', array(__CLASS__, 'me_login_form'));
        // Prepare html
        add_shortcode('me_seller_profile', array(__CLASS__, 'me_seller_profile'));
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
        global $wp;
        if (isset($wp->query_vars['edit-profile'])) {
            return self::me_user_edit_profile();
        } elseif (isset($wp->query_vars['change-password'])) {
            return self::me_change_password();
        } elseif (isset($wp->query_vars['listings'])) {
            return self::me_user_listings();
        }elseif (isset($wp->query_vars['orders'])) {
            return self::me_user_orders();
        }elseif (isset($wp->query_vars['purchases'])) {
            return self::me_user_purchases();
        }elseif (isset($wp->query_vars['listing-id'])) {
            return self::me_user_edit_listing();
        }
        return self::me_user_profile();
    }

    public static function authentication_template() {
        global $wp;
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
        $user = ME()->get_current_user();
        ob_start();
        me_get_template('account/change-password', array('user' => $user));
        $content = ob_get_clean();
        return $content;
    }

    public static function me_user_listings() {
        ob_start();
        me_get_template('account/my-listings');
        $content = ob_get_clean();
        return $content;
    }

    public static function me_user_edit_listing() {
        ob_start();
        $listing_id = get_query_var('listing-id');
        $listing = me_get_listing($listing_id);

        me_get_template('post-listing/edit-listing', array('listing' => $listing));
        $content = ob_get_clean();
        return $content;
    }

    public static function me_user_orders() {
        ob_start();
        me_get_template('account/my-orders');
        $content = ob_get_clean();
        return $content;
    }
    public static function me_user_purchases() {
        ob_start();
        me_get_template('account/my-purchases');
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

    public static function me_seller_profile() {
        ob_start();
        me_get_template('global/seller-profile');
        $content = ob_get_clean();
        return $content;
    }
}
ME_Shortcodes_Auth::init_shortcodes();