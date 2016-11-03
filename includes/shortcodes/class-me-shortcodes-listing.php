<?php
class ME_Shortcodes_Listing
{
    public static function init_shortcodes()
    {
        add_shortcode('me_post_listing_form', array(__CLASS__, 'post_listing_form'));
        add_shortcode('me_listings', array(__CLASS__, 'the_listing'));
    }
    public static function post_listing_form()
    {
        ob_start();
        me_get_template('post-listing/post-listing');
        $content = ob_get_clean();
        return $content;
    }

    public static function the_listing()
    {
        ob_start();
        query_posts( array('post_type' => 'listing', 'post_status' => 'publish', 'paged' => get_query_var( 'page' )) );
        me_get_template('listing-list');
        $content = ob_get_clean();
        wp_reset_query();
        return $content;
    }

}
ME_Shortcodes_Listing::init_shortcodes();