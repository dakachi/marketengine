<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function me_add_user_meta($meta) {
    if (isset($_POST['location'])) {
        $meta['location'] = $_POST['location'];
    }
    return $meta;
}
add_filter('insert_user_meta', 'me_add_user_meta');