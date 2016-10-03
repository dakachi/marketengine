<?php
/**
 *	Post listing button
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<a href="<?php echo me_get_page_permalink('post_listing') ?>" class="me-post-listing"><i class="icon-me-add-circle"></i><span class="me-hidden-xs"><?php echo __('Post Listing', 'enginethemes'); ?></span></a>