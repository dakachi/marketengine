<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Class ME Handle CF
 * Handle MarketEngine Custom Field in post, edit listing form and listing details
 * 
 * @package Includes/CustomFields
 * @category Class
 * 
 * @version 1.0
 */
class ME_Handle_CF
{
	function __construct() {
		add_action( 'marketengine_after_post_listing_information_form', array($this, 'post_form_fields') );
		add_action('marketengine_after_single_listing_details', array($this, 'field_details'));
	}

	public function post_form_fields() {
		me_get_template('custom-fields/field-form');
	}

	public function field_details() {
		me_get_template('custom-fields/field-details');
	}
}
new ME_Handle_CF();
