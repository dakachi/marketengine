<?php
class ME_Shortcodes_Listing {
    public static function init_shortcodes() {
        add_shortcode('me_post_listing_form', array(__CLASS__, 'post_listing_form'));
        add_shortcode('me_listings', array(__CLASS__, 'the_listing'));
    }
    public static function post_listing_form() {
    	ob_start();
        me_get_template_part('post-listing/post-listing');
        $content = ob_get_clean();
        return $content;
    }

    public static function the_listing() {
    	
    }
}
ME_Shortcodes_Listing::init_shortcodes();