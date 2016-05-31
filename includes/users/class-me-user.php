<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * ME_User
 *
 * User behavior manager
 *
 * @class       ME User
 * @version     1.0
 * @package     MarketEngine/Users
 * @author      EngineThemesTeam
 * @category    Class
 */
class ME_User {
    public $id;
    public $user_data;
    public function __construct($user) {
        $this->id = $user->ID;
        $this->user_data = $user->user_data;
    }

    public function __get($name) {
        if (isset($this->user_data[$name])) {
            return $this->user_data[$name];
        }
        return get_the_author_meta($name, $this->id);
    }

    public function is_activated() {
        return (!get_option('is_required_email_confirmation') || !get_user_meta($this->id, 'user_activate_email_key', true));
    }

    public function get_avatar() {
        return get_avatar($this->id);
    }
}