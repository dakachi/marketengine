<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

class ME_Listing_Contact extends ME_Listing {
	public $contact_info;
	public function get_contact_info() {
		return get_post_meta($this->id, 'contact_email', true);
	}

	public function get_inquiry_users() {
		
	}
}