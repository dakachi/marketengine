<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * MarketEngine Autoloader.
 *
 * @class 		ae_Autoloader
 * @version		2.3.0
 * @package		MarketEngine/Classes/
 * @category	Class
 * @author 		MarketEngine
 */
class ae_Autoloader {

	/**
	 * Path to the includes directory.
	 *
	 * @var string
	 */
	private $include_path = '';

	/**
	 * The Constructor.
	 */
	public function __construct() {
		if ( function_exists( "__autoload" ) ) {
			spl_autoload_register( "__autoload" );
		}

		spl_autoload_register( array( $this, 'autoload' ) );

		$this->include_path = untrailingslashit( plugin_dir_path( ae_PLUGIN_FILE ) ) . '/includes/';
	}

	/**
	 * Take a class name and turn it into a file name.
	 *
	 * @param  string $class
	 * @return string
	 */
	private function get_file_name_from_class( $class ) {
		return 'class-' . str_replace( '_', '-', $class ) . '.php';
	}

	/**
	 * Include a class file.
	 *
	 * @param  string $path
	 * @return bool successful or not
	 */
	private function load_file( $path ) {
		if ( $path && is_readable( $path ) ) {
			include_once( $path );
			return true;
		}
		return false;
	}

	/**
	 * Auto-load ME classes on demand to reduce memory consumption.
	 *
	 * @param string $class
	 */
	public function autoload( $class ) {
		$class = strtolower( $class );
		$file  = $this->get_file_name_from_class( $class );
		$path  = '';

		if ( strpos( $class, 'ae_addons_gateway_' ) === 0 ) {
			$path = $this->include_path . 'gateways/' . substr( str_replace( '_', '-', $class ), 18 ) . '/';
		} elseif ( strpos( $class, 'ae_gateway_' ) === 0 ) {
			$path = $this->include_path . 'gateways/' . substr( str_replace( '_', '-', $class ), 11 ) . '/';
		} elseif ( strpos( $class, 'ae_shipping_' ) === 0 ) {
			$path = $this->include_path . 'shipping/' . substr( str_replace( '_', '-', $class ), 12 ) . '/';
		} elseif ( strpos( $class, 'ae_shortcode_' ) === 0 ) {
			$path = $this->include_path . 'shortcodes/';
		} elseif ( strpos( $class, 'ae_meta_box' ) === 0 ) {
			$path = $this->include_path . 'admin/meta-boxes/';
		} elseif ( strpos( $class, 'ae_admin' ) === 0 ) {
			$path = $this->include_path . 'admin/';
		} elseif ( strpos( $class, 'ae_cli_' ) === 0 ) {
			$path = $this->include_path . 'cli/';
		}

		if ( empty( $path ) || ( ! $this->load_file( $path . $file ) && strpos( $class, 'ae_' ) === 0 ) ) {
			$this->load_file( $this->include_path . $file );
		}
	}
}

new ae_Autoloader();
