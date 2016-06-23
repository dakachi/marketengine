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
			<div class="me-col-md-9">
				<div class="marketengine-content-detail">
					<?php me_get_template_part('single-listing/title');?>
					<?php me_get_template_part('single-listing/gallery');?>
					<?php me_get_template_part('single-listing/description');?>
					<?php me_get_template_part('single-listing/rating');?>
				</div>
			</div>
			<div class="me-col-md-3">
				<div class="marketengine-sidebar-detail">
					<?php me_get_template_part('single-listing/status');?>
					<?php me_get_template_part('single-listing/'. $listing_type );?>
					<?php me_get_template_part('single-listing/control-action');?>
					<?php me_get_template_part('single-listing/statistic');?>
					<?php me_get_template_part('single-listing/category');?>
					<?php me_get_template_part('single-listing/tags');?>
				</div>
			</div>
		</div>
	</div>
</div>
