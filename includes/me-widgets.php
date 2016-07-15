<?php
/**
 * MarketEngine Widget Functions
 *
 * Widget related functions and widget registration.
 *
 */

if (!defined('ABSPATH')) {
    exit;
}

include_once ('widgets/class-me-widget-listing-categories.php');

function me_register_widgets() {
    register_widget('ME_Widget_Listing_Categories');
}
add_action('widgets_init', 'me_register_widgets');

