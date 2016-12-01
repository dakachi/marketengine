<?php
/**
 * The template for displaying a notice when listing has been archived.
 *
 * This template can be overridden by copying it to yourtheme/marketengine/purchases/order-listing-image.php.
 *
 * @package     MarketEngine/Templates
 * @since 		1.0.0
 * @version     1.0.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
?>

<?php if(!$listing_obj || !$listing_obj->is_available() ) : ?>

<p class="me-item-archive"><i class="icon-me-info-circle"></i><?php _e('This listing has been archived.', 'enginethemes'); ?></p>

<?php endif; ?>