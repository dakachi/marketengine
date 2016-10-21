<?php 
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

global $post;
$listing = new ME_Listing($post);
$order_count = $listing->get_order_count();
$review_count = $listing->get_review_count();
$listing_type = $listing->get_listing_type();
?>

<?php do_action('marketengine_before_single_listing_statistic'); ?>
	<?php if('contact' === $listing_type) : ?>
		<div class="me-rating-contact">
			<span class="me-count-contact">
			<?php printf(_n("%d Contact", "%d Contacts", $review_count,"enginethemes"),$review_count ); ?>
		</span>
		</div>
	<?php endif; ?>

	<?php if('purchasion' == $listing_type) : ?>
		<div class="me-rating-purchases">
			<span class="me-count-purchases">
				<?php printf(_n("%d Purchase", "%d Purchases", $review_count,"enginethemes"),$review_count ); ?>
			</span>
			<span class="me-count-review">
				<?php printf(_n("%d Review", "%d Reviews", $review_count,"enginethemes"),$review_count ); ?>
			</span>
		</div>	
	<?php endif; ?>
<?php do_action('marketengine_after_single_listing_statistic'); ?>