<?php
/**
 * The template for displaying a notice when listing has been archived.
 *
 * This template can be overridden by copying it to yourtheme/marketengine/purchases/archived-listing-notice.php.
 *
 * @package     MarketEngine/Templates
 * @since 		1.0.1
 * @version     1.0.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
?>
<p class="me-item-archive">
	<i class="icon-me-info-circle"></i><?php _e('This listing has been deleted.', 'enginethemes'); ?>
</p>


