<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class ME_Endpoint_Options_Handle{
    public function endpoint_sync() {
        $a = me_setting_endpoint_name();
        me_init_endpoint();
        flush_rewrite_rules();
        wp_send_json( $a );
    }
}


