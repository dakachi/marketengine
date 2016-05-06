<?php
/**
 * Install MarketEngine database, hook and action
 * @class       ME_Install
 * @version     1.0
 * @package     MarketEngine/Classes
 * @category    Admin
 * @author      EngineThemes
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
/**
  * MarketEngine Installation Class
 */
class ME_Install {
	/**
	 * The single instance of the class.
	 *
	 * @var ME_Install
	 * @since 1.0
	 */
	protected static $_instance = null;

	/**
	 * Main ME_Install Instance.
	 *
	 * Ensures only one instance of ME_Install is loaded or can be loaded.
	 *
	 * @since 1.0
	 * @static
	 * @see ME()
	 * @return ME_Install - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public static function init() {
		add_action( 'init', array( __CLASS__, 'install' ) );

	}

	/**
	 * Check MarketEngine version and run the updater is required.
	 *
	 * This check is done on all requests and runs if he versions do not match.
	 */
	public static function check_version() {
		if ( ! defined( 'IFRAME_REQUEST' ) && get_option( 'marketengine_version' ) !== ME()->version ) {
			self::install();
			do_action( 'marketengine_updated' );
		}
	}

	public static function install() {
		// TODO: Create table
		self::create_tables();
		// Create role
		self::add_roles();
		// update version to option
		self::update_version();
	}

	public static function create_tables() {
		global $wpdb;

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$collate = '';
		if ( $wpdb->has_cap( 'collation' ) ) {
			if ( ! empty( $wpdb->charset ) ) {
				$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if ( ! empty( $wpdb->collate ) ) {
				$collate .= " COLLATE $wpdb->collate";
			}
		}

		$schemas = "CREATE TABLE {$wpdb->prefix}marketengine_order_items (
					order_item_id bigint(20) NOT NULL auto_increment,
					order_item_name longtext NOT NULL,
					order_item_type varchar(200) NOT NULL DEFAULT '',
					order_id bigint(20) NOT NULL,
					PRIMARY KEY  (order_item_id),
					KEY order_id (order_id)
				) $collate;

			CREATE TABLE {$wpdb->prefix}marketengine_custom_fields (
					field_id bigint(20) NOT NULL auto_increment,
					field_name varchar(20) NOT NULL,
					field_label longtext NOT NULL,
					field_type longtext NOT NULL,
					field_input_type longtext NOT NULL,
					field_placeholder varchar(200) NOT NULL DEFAULT '',
					field_description varchar(200) NOT NULL DEFAULT '',
					field_constraint varchar(200) NOT NULL DEFAULT '',
					PRIMARY KEY  (field_id),
					KEY field_name (field_name)
				) $collate;

		CREATE TABLE {$wpdb->prefix}marketengine_order_itemmeta (
					meta_id bigint(20) NOT NULL auto_increment,
					order_item_id bigint(20) NOT NULL,
					meta_key varchar(255) NULL,
					meta_value longtext NULL,
					PRIMARY KEY  (meta_id),
					KEY order_item_id (order_item_id),
					KEY meta_key (meta_key)
				) $collate;

		CREATE TABLE {$wpdb->prefix}marketengine_sessions (
					session_id bigint(20) NOT NULL AUTO_INCREMENT,
					session_key char(32) NOT NULL,
					session_value longtext NOT NULL,
					session_expiry bigint(20) NOT NULL,
					UNIQUE KEY session_id (session_id),
					PRIMARY KEY  (session_key)
				) $collate;
		";

		dbDelta( $schemas );
	}

	public static function add_roles() {

	}

	public static function update_version() {

	}

}

ME_Install::init();