<?php
class ME_Shortcodes_Listing {
    public static function init_shortcodes() {
        add_shortcode('me_post_listing_form', array(__CLASS__, 'post_listing_form'));
    }
    public static function post_listing_form() {
    	ob_start();
        me_get_template_part('post-listing/post-listing');
        $content = ob_get_clean();
        return $content;
    }
}
ME_Shortcodes_Listing::init_shortcodes();