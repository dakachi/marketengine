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

<div class="me-rating">
	<i class="icon-font star-off-png"></i>
	<i class="icon-font star-off-png"></i>
	<i class="icon-font star-off-png"></i>
	<i class="icon-font star-off-png"></i>
	<i class="icon-font star-off-png"></i>
</div>
<div class="me-purchase">
	<span><i class="icon-cart"></i><?php printf(_n("<b>%d</b>Purchase", "<b>%d</b>Purchases", $order_count,"enginethemes"),$order_count ); ?></span>
</div>
<div class="me-reviews">
	<span><i class="icon-reviews"></i><?php printf(_n("<b>%d</b>Review", "<b>%d</b>Reviews", $review_count,"enginethemes"),$review_count ); ?></span>
</div>

<?php do_action('marketengine_after_single_listing_statistic'); ?>