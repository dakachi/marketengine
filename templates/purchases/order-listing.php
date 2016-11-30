<?php //if($listing_obj && $listing_obj->is_available() ) :

?>
<div class="me-orderlisting-info">
	<a class="me-orderlisting-thumbs" href="<?php echo $listing_obj->get_permalink(); ?>"><?php echo $listing_obj->get_listing_thumbnail(); ?></a>
	<div class="me-listing-info">
		<h2><a href="<?php echo $listing_obj->get_permalink(); ?>"><?php echo esc_html($cart_listing['title']); ?></a></h2>
		<div class="me-rating">
			<div class="result-rating" data-score="<?php echo $listing_obj->get_review_score(); ?>"></div>
		</div>
		<div class="me-count-purchases-review">
			<?php // <span>12 Purchase</span><span>30 review</span> ?>
		</div>
		<div class="me-listing-desc">
			<div class="me-listing-desc-less">
				<?php echo $listing_obj->get_short_description(20); ?>
			</div>
			<div class="me-listing-desc-more">
				<p><?php echo $listing_obj->get_description(); ?></p>
			</div>
		</div>
		<a class="me-listing-info-view"><span><?php _e('view more', 'enginethemes'); ?></span><span><?php _e('view less', 'enginethemes'); ?></span></a>

	</div>

	<?php
		$seller = $listing_obj->get_author();
		$can_rate = $seller != get_current_user_id();
	?>
	<?php if( $can_rate  && !me_get_user_rate_listing_score($listing_obj->ID, $transaction->post_author) && !$transaction->has_status('me-pending') ) : ?>
		<a class="me-orderlisting-review" href="<?php echo add_query_arg(array('id' => $listing_obj->ID, 'action' => 'review')); ?>">
			<?php _e('RATE &amp; REVIEW NOW', 'enginethemes'); ?>
		</a>
	<?php endif; ?>

	<?php if($listing_obj->post_status === "me-archived") : ?>
	<p class="me-item-archive"><i class="icon-me-info-circle"></i><?php _e('This listing has been archived.', 'enginethemes'); ?></p>
	<?php endif; ?>
</div>
<?php /* else : ?>
<div class="me-orderlisting-info">
<?php var_dump($listing_obj); ?>
	<?php _e("The listing has already remove or archived.", "enginethemes"); ?>
</div>
<?php endif; */?>