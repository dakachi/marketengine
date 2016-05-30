<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * ME Template Loader
 * 
 * @version     1.0
 * @package     MarketEngine/Includes
 * @author      Dakachi
 * @category    Class
 */
class ME_Template_Loader {
	

	public static function init_hooks() {
		add_filter( 'template_include', array( __CLASS__, 'template_include' ));
	}

	public static function template_include( $template ) {
		return $template;
	}
}

ME_Template_Loader::->init_hooks();