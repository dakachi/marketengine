<?php
/**
 * The template for displaying thumbnail of listing ordered.
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
<a class="me-orderlisting-thumbs" href="<?php echo $listing_obj && $listing_obj->is_available() ? $listing_obj->get_permalink() : "javascript:void(0)"; ?>"><?php echo $listing_obj->get_listing_thumbnail() ? $listing_obj->get_listing_thumbnail() : '<i class="icon-me-image"></i>'; ?></a>