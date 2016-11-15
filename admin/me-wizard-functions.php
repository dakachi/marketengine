<?php
function me_create_page() {
	if( is_admin() ) {
		$default_pages = me_default_pages();

		foreach( $default_pages as $key => $page){

			$args = array(
				'post_status' => 'publish',
				'post_type' => 'page',
			);

			$args = wp_parse_args( $args, $page );

			$page_id = wp_insert_post( $args);

			if(!is_wp_error($page_id)) {
				me_update_option( 'me_'.$key.'_page_id', $page_id  );
			}
		}

	}
}

function me_default_pages() {
	return array(
		'user_account'		=> array(
			'post_title'	=> 'User Account Page',
			'post_content' 	=> '[me_user_account_page]',
		),
		'post_listing'		=> array(
			'post_title'	=> 'Post Listing Page',
			'post_content' 	=> '[me_post_listing_form]',
		),
		'edit_listing'		=> array(
			'post_title'	=> 'Edit Listing Page',
			'post_content' 	=> '[me_edit_listing_form]',
		),
		'checkout'		=> array(
			'post_title'	=> 'Checkout Page',
			'post_content' 	=> '[me_checkout_form]',
		),
		'confirm_order'		=> array(
			'post_title'	=> 'Confirm Order Page',
			'post_content' 	=> '[me_confirm_order]',
		),
		'cancel_order'		=> array(
			'post_title'	=> 'Cancel Order Page',
			'post_content' 	=> '[me_cancel_payment]',
		),
		'inquiry'		=> array(
			'post_title'	=> 'Inquiry Page',
			'post_content' 	=> '[me_inquiry_form]',
		),
	);
}