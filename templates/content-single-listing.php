<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$listing = me_get_listing();
$listing_type = $listing->get_listing_type();
$buyer = $listing->post_author == get_current_user_id();
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

					<?php
					if($listing_type) :
						if( $buyer ) :
							me_get_template('single-listing/status' );
							me_get_template('single-listing/control-action', array('listing_type' => $listing_type , 'purchasion' => $purchasion) );
						else :
							me_get_template('single-listing/'. $listing_type );
						endif;
					endif;
					?>
					<?php me_get_template('single-listing/category');?>
					<?php
					if( !$buyer ) :
						me_get_template('single-listing/author', array('author_id' => $listing->post_author));
						me_get_template('single-listing/report');
					endif;
					?>
				</div>

				<?php do_action('marketengine_after_single_listing_sidebar'); ?>

			</div>
		</div>
	</div>
</div>
