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
		<div class="me-row">
			<div class="me-col-md-12">
				<?php me_get_template_part('single-listing/title');?>
				<?php me_get_template_part('single-listing/statistic');?>
			</div>
		</div>
		<div class="me-row">
			<div class="me-col-md-9">

				<?php do_action('marketengine_before_single_listing_details'); ?>

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
					<?php me_get_template_part('single-listing/category');?>		
					<?php me_get_template_part('single-listing/author');?>			
					<?php me_get_template_part('single-listing/report');?>
				</div>

				<?php do_action('marketengine_after_single_listing_sidebar'); ?>

			</div>
		</div>
	</div>
</div>
