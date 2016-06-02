<?php
/*
Plugin Name: MarketEngine
Plugin URI: www.enginethemes.com
Description: Easy implement a front form, and publish a marketplace application
Version: 1.0
Author: EngineThemes team
Author URI: https://enginethemes.com
Domain Path: enginethemes
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('MarketEngine')):

    class MarketEngine {
        /**
         * The single instance of the class.
         *
         * @var MarketEngine
         * @since 1.0
         */
        protected static $_instance = null;

        /**
         * The string of plugin version.
         *
         * @var MarketEngine
         * @since 1.0
         */
        public $version = '1.0';

        /**
         * Main MarketEngine Instance.
         *
         * Ensures only one instance of MarketEngine is loaded or can be loaded.
         *
         * @since 1.0
         * @static
         * @see ME()
         * @return MarketEngine - Main instance.
         */
        public static function instance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function __construct() {
            // TODO: init alot of thing here
            $this->define();
            $this->include_files();
            $this->init_hooks();
            /**
             * Fires after the plugin is loaded.
             *
             * @since 1.0.0
             */
            do_action('marketengine_loaded');
        }

        private function define() {
            if (!defined('ME_PLUGIN_PATH')) {
                define('ME_PLUGIN_PATH', dirname(__FILE__));
            }
        }

        private function include_files() {
            require_once ME_PLUGIN_PATH . '/includes/class-me-autoloader.php';

            require_once ME_PLUGIN_PATH . '/includes/class-me-install.php';
            require_once ME_PLUGIN_PATH . '/includes/class-me-session.php';
            require_once ME_PLUGIN_PATH . '/includes/class-me-validator.php';
            require_once ME_PLUGIN_PATH . '/includes/class-me-post-types.php';
            require_once ME_PLUGIN_PATH . '/includes/class-me-query.php';

            require_once ME_PLUGIN_PATH . '/includes/me-notices-functions.php';
            require_once ME_PLUGIN_PATH . '/includes/me-template-functions.php';
            require_once ME_PLUGIN_PATH . '/includes/me-email-functions.php';

            require_once ME_PLUGIN_PATH . '/includes/abstracts/class-abstract-form.php';
            require_once ME_PLUGIN_PATH . '/includes/authentication/class-me-authentication-form.php';
            require_once ME_PLUGIN_PATH . '/includes/authentication/class-me-authentication.php';

            require_once ME_PLUGIN_PATH . '/includes/listings/class-me-listing.php';

            require_once ME_PLUGIN_PATH . '/includes/shortcodes/class-me-shortcodes-auth.php';
            require_once ME_PLUGIN_PATH . '/includes/shortcodes/class-me-shortcodes-listing.php';
        }

        private function init_hooks() {
            add_action('init', array($this, 'init'));
            add_action('wp_enqueue_scripts', array($this, 'add_scripts'));
        }

        public function init() {
            $this->session = ME_Session::instance();

            ME_Post_Types::register_post_type();
            ME_Post_Types::register_tanonomies();
        }

        public function add_scripts() {
            wp_enqueue_style('me_font_icon', $this->plugin_url() . '/assets/css/marketengine-font-icon.css');
            wp_enqueue_style('me_layout', $this->plugin_url() . '/assets/css/marketengine-layout.css');

            wp_enqueue_script('user-profile', $this->plugin_url() . '/assets/js/user-profile.js', array('jquery'));
        }

        /**
         * Get the plugin url.
         * @return string
         */
        public function plugin_url() {
            return untrailingslashit(plugins_url('/', __FILE__));
        }

        /**
         * Get the plugin path.
         * @return string
         */
        public function plugin_path() {
            return untrailingslashit(plugin_dir_path(__FILE__));
        }

        /**
         * Get the template path.
         * @return string
         */
        public function template_path() {
            return apply_filters('marketengine_template_path', 'marketengine/');
        }

        public function get_current_user() {
            global $current_user;
            return new ME_User($current_user);
        }

    }
endif;
/**
 * Main MarketEngine Instance.
 */
function ME() {
    return MarketEngine::instance();
}

$GLOBALS['marketengine'] = ME();