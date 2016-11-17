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

function marketengine_add_sample_order()
{

}

function marketengine_add_sample_inquiry()
{

}

function marketengine_add_sample_review()
{

}

function marketengine_add_sample_user($user_data)
{
    // add user
    $defaults = array(
        'user_login'   => 'henrywilson',
        'first_name'   => 'Henry',
        'last_name'    => 'Wilson',
        'user_email'   => 'henrywilson@mailinator.com',
        'location'     => 'UK',
        'user_pass'    => '123',
        'avatar'       => 'http://lorempixel.com/150/150/business/',
        'paypal_email' => 'dinhle1987-buyer@yahoo.com',
    );
    $user_data = wp_parse_args($user_data, $defaults);
    $user      = get_user_by('login', $user_data['user_login']);
    if (!$user) {
        $user_id = wp_insert_user($user_data);
        update_user_meta($user_id, 'paypal_email', $user_data['paypal_email']);
        update_user_meta($user_id, 'location', $user_data['location']);
    }
    return $user->ID;
}

function marketengine_handle_sample_image($image, $filename)
{
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image);
    $filename .= '.jpg';
    if (wp_mkdir_p($upload_dir['path'])) {
        $file = $upload_dir['path'] . '/' . $filename;
    } else {
        $file = $upload_dir['basedir'] . '/' . $filename;
    }

    file_put_contents($file, $image_data);
    $wp_filetype = wp_check_filetype($filename, null);
    $attachment  = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title'     => sanitize_file_name($filename),
        'post_status'    => 'auto',
        'post_content'   => '',
        'post_status'    => 'inherit',
    );
    $attach_id = wp_insert_attachment($attachment, $file, $post_id);
    require_once ABSPATH . '/wp-admin/includes/image.php';
    $attach_data = wp_generate_attachment_metadata($attach_id, $file);
    wp_update_attachment_metadata($attach_id, $attach_data);
    return $attach_id;
}

function marketengine_add_sample_listing()
{

    $listing_number = $_POST['number'];

    $listing                = include ME_PLUGIN_PATH . '/sample-data/listing/listing-' . $listing_number . '.php';
    $user_id                = marketengine_add_sample_user($listing['post_author']);
    $listing['post_author'] = $user_id;

    $cats = $listing['listing_category'];

    $cat_1 = wp_insert_term($cats[0], 'listing_category');
    if (!is_wp_error($cat_1)) {
        $cat_id_1 = $cat_1['term_id'];
    } else {
        $cat_id_1 = $cat_1->error_data['term_exists'];
    }

    $cat_2 = wp_insert_term($cats[1], 'listing_category', array('parent' => $cat_id_1));
    if (!is_wp_error($cat_2)) {
        $cat_id_2 = $cat_2['term_id'];
    } else {
        $cat_id_2 = $cat_2->error_data['term_exists'];
    }

    $listing['tax_input'] = array(
        'listing_tag'      => $listing['listing_tag'],
        'listing_category' => array($cat_id_1, $cat_id_2),
    );

    $img_1 = marketengine_handle_sample_image('http://lorempixel.com/800/600/technics/', $listing['post_name'] . '-1');
    $img_2 = marketengine_handle_sample_image('http://lorempixel.com/800/600/transport/', $listing['post_name'] . '-2');
    $img_3 = marketengine_handle_sample_image('http://lorempixel.com/800/600/food/', $listing['post_name'] . '-2');
    $listing['listing_gallery'] = array(
        $img_1,
        $img_2,
        $img_3
    );
    
    $listing['meta_input']['_thumbnail_id'] = $img_1;
    $result = wp_insert_post($listing);

    update_post_meta($result, '_me_listing_gallery', $listing['listing_gallery']);

    if (!empty($listing['order'])) {
        marketengine_add_sample_order($listing['order']);
    }

    if (!empty($listing['inquiry'])) {
        marketengine_add_sample_inquiry($listing['inquiry']);
    }
}

