<?php
/**
 * Marketengine Filter user placeholder tag
 *
 * Replace the user place holder tag with user data
 *
 * @since 1.0
 *
 * @param string $content
 * @param WP_User $user
 *
 * @since 1.0
 *
 * @return string
 */
function me_filter_authentication_placeholder($content, $user = null) {
    if (!$user) {
        $user = ME()->get_current_user();
    }
    $content = str_ireplace('[user_login]', $user->user_login, $content);
    $content = str_ireplace('[user_name]', $user->user_login, $content);

    // user nicename plaholder
    $content = str_ireplace('[user_nicename]', ucfirst($user->user_nicename), $content);

    //member email
    $content = str_ireplace('[user_email]', $user->user_email, $content);

    /**
     * member display name
     */
    $content = str_ireplace('[display_name]', ucfirst($user->display_name), $content);

    /**
     * author posts link
     */
    $author_link = '<a href="' . get_author_posts_url($user->ID) . '" >' . __("Author's Posts", "enginethemes") . '</a>';
    $content     = str_ireplace('[author_link]', $author_link, $content);
    /**
     * filter mail content et_filter_auth_email
     *
     * @param String $content mail content will be filter
     * @param id $user_id The user id who the email will be sent to
     *
     * @since 1.0
     */
    $content = apply_filters('me_filter_authentication_placeholder', $content, $user);

    // filter site info placeholder tag
    $content = str_ireplace('[site_url]', get_bloginfo('url'), $content);
    $content = str_ireplace('[blogname]', get_bloginfo('name'), $content);
    $content = str_ireplace('[admin_email]', get_option('admin_email'), $content);

    return $content;
}

add_filter('marketengine_activation_mail_content', 'me_filter_authentication_placeholder', 10, 2);
add_filter('marketengine_registration_success_mail_content', 'me_filter_authentication_placeholder', 10, 2);
add_filter('marketengine_reset_password_mail_content', 'me_filter_authentication_placeholder', 10, 2);
add_filter('marketengine_reset_password_success_mail_content', 'me_filter_authentication_placeholder', 10, 2);

/**
 * Marketengine Filter post placeholder tag
 *
 * Replace the post place holder tag with post data
 *
 * @since 1.0
 *
 * @param string $content
 * @param WP_Post | int $post
 *
 * @since 1.0
 *
 * @return string
 */
function me_filter_post_placeholder($content, $post = '') {
    if (is_numeric($post)) {
        $post = get_post(absint($post));
    }

    if (!$post || is_wp_error($post)) {
        return $content;
    }

    $title = apply_filters('the_title', $post->post_title);

    /**
     * post content
     */
    $content = str_ireplace('[title]', $title, $content);
    $content = str_ireplace('[desc]', apply_filters('the_content', $post->post_content), $content);
    $content = str_ireplace('[excerpt]', apply_filters('the_excerpt', $post->post_excerpt), $content);
    $content = str_ireplace('[author]', get_the_author_meta('display_name', $post->post_author), $content);

    /**
     * post link
     */
    $post_link = '<a href="' . get_permalink($post_id) . '" >' . $title . '</a>';
    $content   = str_ireplace('[link]', $post_link, $content);

    /**
     * author posts link
     */
    $author_link = '<a href="' . get_author_posts_url($post->post_author) . '" >' . __("Author's Posts", "enginethemes") . '</a>';
    $content     = str_ireplace('[author_link]', $author_link, $content);

    /**
     * filter mail content et_filter_ad_email
     *
     * @param String $content mail content will be filter
     * @param id $user_id The post id which the email is related to
     *
     * @since 1.0
     */
    $content = apply_filters('me_filter_post_placeholder', $content, $post_id);

    return $content;
}

/**
 * Send complete order email to seller
 */
function me_complete_order_email($order_id) {
    if (!$order_id) {
        return false;
    }

    $order = new ME_Order($order_id);
    $commission = 0;

    $receiver_item = me_get_order_items($order_id, 'receiver_item');
    $commision_item = me_get_order_items($order_id, 'commission_item');

    if (empty($receiver_item)) {
        return false;
    }

    if(!empty($commission_item)) {
        $commission = me_get_order_item_meta($commission_item[0]->order_item_id, '_amount', true);
    }

    $user_name = $receiver_item[0]->order_item_name;

    $seller = get_user_by('user_login', $user_name);
    if (!$seller) {
        return false;
    }

    $listing_item = me_get_order_items($order_id, 'listing_item');
    $listing_id = me_get_order_item_meta($listing_item[0]->order_item_id, '_listing_id', true);

    $subject = sprintf(__("You have a new order on %s.", "enginethemes"), get_bloginfo('blogname'));
    ob_start();
    me_get_template('email/order-success',
        array(
            'display_name' => get_the_author_meta( 'display_name', $seller->ID ),
            'listing_link' => get_permalink($listing_id),
            'buyer_name' => get_the_author_meta( 'display_name', $order->post_author ),
            'listing_price' => me_get_order_item_meta($listing_item[0]->order_item_id,'_listing_price', true),
            'total' => $order->get_total(),
            'commission' => $commission,
            'currency' => $order->get_currency(),
            'order_link' => $order->get_order_detail_url()
        )
    );
    $message = ob_get_clean();

    wp_mail($seller->user_email, $subject, $message);

}
add_action('marketengine_complete_order', 'me_complete_order_email');