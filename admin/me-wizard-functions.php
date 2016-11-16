<?php
/**
 * Create functional pages supported by MarketEngine
 * 
 * @package Admin/Setupwizard
 * @category Function
 *
 * @since 1.0
 */
function me_create_functional_pages()
{
    
    $default_pages = me_get_functional_pages();

    foreach ($default_pages as $key => $page) {

        $args = array(
            'post_status' => 'publish',
            'post_type'   => 'page',
        );

        $args = wp_parse_args($args, $page);

        $page_id = wp_insert_post($args);

        if ($page_id) {
            me_update_option('me_' . $key . '_page_id', $page_id);
        }
        flush_rewrite_rules();
    }
}

/**
 * Retrieve list of name and content of functional pages supported by MarketEngine
 * 
 * @package Admin/Setupwizard
 * @category Function
 * 
 * @return array
 * @since 1.0
 */
function me_get_functional_pages()
{
    return array(
        'user_account'  => array(
            'post_title'   => __("User Account", "enginethemes"),
            'post_content' => '[me_user_account]',
        ),
        'post_listing'  => array(
            'post_title'   => __("Post Listing", "enginethemes"),
            'post_content' => '[me_post_listing_form]',
        ),
        'edit_listing'  => array(
            'post_title'   => __("Edit Listing", "enginethemes"),
            'post_content' => '[me_edit_listing_form]',
        ),
        'checkout'      => array(
            'post_title'   => __("Checkout Page", "enginethemes"),
            'post_content' => '[me_checkout_form]',
        ),
        'confirm_order' => array(
            'post_title'   => __("Thank you for payment", "enginethemes"),
            'post_content' => '[me_confirm_order]',
        ),
        'cancel_order'  => array(
            'post_title'   => __("Cancel Order", "enginethemes"),
            'post_content' => '[me_cancel_payment]',
        ),
        'inquiry'       => array(
            'post_title'   => __("Inquiry", "enginethemes"),
            'post_content' => '[me_inquiry_form]',
        ),
    );
}

function marketengine_add_sample_user() {

}

function marketengine_add_sample_listing() {
	// insert listing
	// insert order | inquiry
	// order
}

function marketengine_add_sample_order(){

}

function marketengine_add_sample_inquiry(){

}

function marketengine_add_sample_message(){
    
}