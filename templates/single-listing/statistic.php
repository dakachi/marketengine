<?php 
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

global $post;
$listing = new ME_Listing($post);
$order_count = $listing->get_order_count();
$review_count = $listing->get_review_count();
?>

<?php do_action('marketengine_before_single_listing_statistic'); ?>

<div class="me-rating-contact">
	<div class="me-rating">
		<i class="icon-font star-on-png"></i>
		<i class="icon-font star-on-png"></i>
		<i class="icon-font star-on-png"></i>
		<i class="icon-font star-half-png"></i>
		<i class="icon-font star-off-png"></i>
	</div>
	<span class="me-count-contact"><?php printf(_n("%d Contact", "%d Contacts", $review_count,"enginethemes"),$review_count ); ?></span>|<span class="me-count-review"><?php printf(_n("%d Review", "%d Reviews", $review_count,"enginethemes"),$review_count ); ?></span>
</div>

<?php do_action('marketengine_after_single_listing_statistic'); ?>