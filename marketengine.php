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
         * @var version
         * @since 1.0
         */
        public $version = '1.0';
        /**
         * The object of current user data
         *
         * @var current_user
         * @since 1.0
         */
        public $current_user;
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
            require_once ME_PLUGIN_PATH . '/includes/class-me-template-loader.php';

            require_once ME_PLUGIN_PATH . '/includes/me-notices-functions.php';
            require_once ME_PLUGIN_PATH . '/includes/me-template-functions.php';
            require_once ME_PLUGIN_PATH . '/includes/me-email-functions.php';
            require_once ME_PLUGIN_PATH . '/includes/me-listing-functions.php';
            require_once ME_PLUGIN_PATH . '/includes/me-order-functions.php';
            require_once ME_PLUGIN_PATH . '/includes/me-conversation-functions.php';
            require_once ME_PLUGIN_PATH . '/includes/me-user-functions.php';
            require_once ME_PLUGIN_PATH . '/includes/me-widgets.php';

            require_once ME_PLUGIN_PATH . '/includes/abstracts/class-abstract-form.php';
            require_once ME_PLUGIN_PATH . '/includes/handle-authentication/class-me-authentication-form.php';
            require_once ME_PLUGIN_PATH . '/includes/handle-authentication/class-me-authentication.php';

            require_once ME_PLUGIN_PATH . '/includes/handle-listings/class-me-listing-handle.php';
            require_once ME_PLUGIN_PATH . '/includes/handle-listings/class-me-listing-handle-form.php';

            require_once ME_PLUGIN_PATH . '/includes/listings/class-me-listing.php';
            require_once ME_PLUGIN_PATH . '/includes/listings/class-me-listing-purchase.php';
            require_once ME_PLUGIN_PATH . '/includes/listings/class-me-listing-contact.php';

            require_once ME_PLUGIN_PATH . '/includes/handle-checkout/class-me-checkout-handle.php';
            require_once ME_PLUGIN_PATH . '/includes/handle-checkout/class-me-checkout-form.php';

            require_once ME_PLUGIN_PATH . '/includes/shortcodes/class-me-shortcodes-auth.php';
            require_once ME_PLUGIN_PATH . '/includes/shortcodes/class-me-shortcodes-listing.php';
        }

        private function init_hooks() {
            add_action('init', array($this, 'init'));
            add_action('wp_enqueue_scripts', array($this, 'add_scripts'));

            add_action('init', array($this, 'wpdb_table_fix'), 0);
        }

        public function init() {
            $this->session = ME_Session::instance();

            ME_Post_Types::register_post_type();
            ME_Post_Types::register_tanonomies();
        }

        public function wpdb_table_fix() {
            global $wpdb;
            $wpdb->marketengine_order_itemmeta = $wpdb->prefix . 'marketengine_order_itemmeta';
            $wpdb->tables[]             = 'marketengine_order_itemmeta';
        }

        public function add_scripts() {
            $develop_src = true;

            if (!defined('ME_SCRIPT_DEBUG')) {
                define('ME_SCRIPT_DEBUG', $develop_src);
            }

            $suffix = ME_SCRIPT_DEBUG ? '' : '.min';
            $dev_suffix = $develop_src ? '' : '.min';

            wp_enqueue_style('me_font_icon', $this->plugin_url() . '/assets/css/marketengine-font-icon.css');
            wp_enqueue_style('me_layout', $this->plugin_url() . '/assets/css/marketengine-layout.css');
            wp_enqueue_style('magnific_popup_css', $this->plugin_url() . '/assets/css/magnific-popup.css');

            wp_enqueue_script('plupload-all');
            wp_enqueue_script('user_profile', $this->plugin_url() . "/assets/js/user-profile$suffix.js", array('jquery'), $this->version, true);
            wp_enqueue_script('tag_box', $this->plugin_url() . "/assets/js/tag-box$suffix.js", array('jquery', 'suggest'), $this->version, true);
            wp_enqueue_script('post_listing', $this->plugin_url() . "/assets/js/post-listing$suffix.js", array('jquery'), $this->version, true);

            wp_enqueue_script('magnific_popup', $this->plugin_url() . "/assets/js/jquery.magnific-popup.min$suffix.js", array('jquery'), $this->version, true);
            wp_enqueue_script('me.sliderthumbs', $this->plugin_url() . "/assets/js/me.sliderthumbs$suffix.js", array('jquery'), $this->version, true);
            wp_enqueue_script('index', $this->plugin_url() . "/assets/js/index$suffix.js", array('jquery'), $this->version, true);

            wp_localize_script(
                'post_listing',
                'me_globals',
                array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                )
            );

            $max_files = apply_filters('marketengine_plupload_max_files', 2);
            $post_params = array(
                "_wpnonce" => wp_create_nonce('media-form'),
                "short" => "1",
                "action" => 'me-upload-file',
            );
            wp_localize_script(
                'plupload',
                'plupload_opt',
                array(
                    'max_file_size' => (wp_max_upload_size() / (1024 * 1024)) . 'mb',
                    'url' => admin_url('admin-ajax.php'),
                    'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
                    'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
                    'max_files' => $max_files,
                    'filters' => array(
                        array(
                            'title' => __('Image Files', "enginethemes"),
                            'extensions' => 'jpg,jpeg,gif,png',
                        ),
                    ),
                    'runtimes' => 'html5,gears,flash,silverlight,browserplus,html4',
                    'multipart_params' => $post_params,
                    'error' => array(
                        'max_files' => sprintf(__("'no more than %d file(s)'", "enginethemes"), $max_files),
                    ),
                )
            );

            me_add_order_item_meta(1, 'order_meta_data', 'Order meta data');
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
            if (null === $this->current_user && $current_user) {
                $this->current_user = new ME_User($current_user);
            }
            return $this->current_user;
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