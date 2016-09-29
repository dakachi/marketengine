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
				<?php me_get_template('single-listing/title');?>
				<?php me_get_template('single-listing/statistic');?>
			</div>
		</div>
		<div class="me-row">
			<div class="me-col-md-9">

				<?php do_action('marketengine_before_single_listing_details'); ?>

				<div class="marketengine-content-detail">
					<?php me_get_template('single-listing/gallery');?>
					<?php me_get_template('single-listing/description');?>
					<?php me_get_template('single-listing/rating');?>
				</div>

				<?php do_action('marketengine_after_single_listing_details'); ?>

			</div>
			<div class="me-col-md-3">

				<?php do_action('marketengine_before_single_listing_sidebar'); ?>

				<div class="marketengine-sidebar-detail">

					<?php //me_get_template('single-listing/status');?>
					<?php
						if($listing_type)
						me_get_template('single-listing/'. $listing_type );
					?>
					<?php me_get_template('single-listing/category');?>
					<?php me_get_template('single-listing/author', array('author_id' => $post->post_author));?>
					<?php me_get_template('single-listing/report');?>
				</div>

				<?php do_action('marketengine_after_single_listing_sidebar'); ?>

			</div>
		</div>
	</div>
</div>
