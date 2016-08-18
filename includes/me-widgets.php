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
include_once ('widgets/class-me-widget-listing-types.php');
include_once ('widgets/class-me-widget-price-filter.php');

function me_register_widgets() {
    register_widget('ME_Widget_Listing_Categories');
    register_widget('ME_Widget_Listing_Types');
    register_widget('ME_Widget_Price_Filter');
}
add_action('widgets_init', 'me_register_widgets');

