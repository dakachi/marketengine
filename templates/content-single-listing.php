<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
global $post;
$listing = new ME_Listing($post);
$listing_type = $listing->get_listing_type();
?>
<div class="marketengine me-container">
	<div itemscope itemtype="http://schema.org/Product" class="marketengine-listing-detail">
		<?php do_action('marketengine_before_single_listing_details'); ?>
		<div class="me-row">
			<div class="me-col-md-12">
				<?php me_get_template_part('single-listing/title');?>
				<div class="me-rating-contact">
					<div class="me-rating"><i class="icon-font star-on-png"></i><i class="icon-font star-on-png"></i><i class="icon-font star-on-png"></i><i class="icon-font star-half-png"></i><i class="icon-font star-off-png"></i></div>
					<span class="me-count-contact">8 Contacts</span>|<span class="me-count-review">8 reviews</span>
				</div>
			</div>
		</div>
		<div class="me-row">
			<div class="me-col-md-9">
				<div class="marketengine-content-detail">

					<?php me_get_template_part('single-listing/gallery');?>
					<?php me_get_template_part('single-listing/description');?>
					<?php me_get_template_part('single-listing/rating');?>

				</div>
		<?php do_action('marketengine_after_single_listing_details'); ?>
			</div>
			<div class="me-col-md-3">

				<?php do_action('marketengine_before_single_listing_sidebar'); ?>

				<div class="marketengine-sidebar-detail">

					<?php me_get_template_part('single-listing/status');?>
					<?php me_get_template_part('single-listing/'. $listing_type );?>
					<?php me_get_template_part('single-listing/control-action');?>
					<?php me_get_template_part('single-listing/statistic');?>
					<?php me_get_template_part('single-listing/category');?>
					<?php me_get_template_part('single-listing/tags');?>
					
				</div>

				<?php do_action('marketengine_after_single_listing_sidebar'); ?>

			</div>
		</div>
	</div>
</div>
