<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function me_add_user_meta($meta) {
    if (isset($_POST['location'])) {
        $meta['location'] = $_POST['location'];
        $meta['paypal_email'] = $_POST['paypal_email'];
    }

    if(!empty($_POST['user_avatar'])) {
    	$meta['user_avatar'] = esc_attr( $_POST['user_avatar'] );
    }

    return $meta;
}
add_filter('insert_user_meta', 'me_add_user_meta');


function me_get_avatar($user_id) {
	$user_avatar = get_user_meta( $user_id, 'user_avatar', true);
    if($user_avatar) {
        $avatar_url = wp_get_attachment_url( $user_avatar );
        return '<img alt="" src="'.$avatar_url.'" class="avatar avartar-{$size} photo" height="{$size}" width="{$size}">';
    }
    return get_avatar( $user_id );
}