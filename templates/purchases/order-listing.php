<div class="me-orderlisting-info">
	<a class="me-orderlisting-thumbs" href="<?php echo $listing_obj->get_permalink(); ?>"><?php echo $listing_obj->get_listing_thumbnail(); ?></a>
	<div class="me-listing-info">
		<h2><a href="<?php echo $listing_obj->get_permalink(); ?>"><?php echo esc_html($listing_obj->get_title()); ?></a></h2>
		<div class="me-rating">
			<div class="result-rating" data-score="<?php echo me_get_user_rate_listing_score($listing_obj->ID, $order->post_author) ; ?>"></div>
		</div>
		<div class="me-count-purchases-review">
			<?php // <span>12 Purchase</span><span>30 review</span> ?>
		</div>
		<p><?php echo $listing_obj->get_description(); ?></p>

		<a class="me-listing-info-view" href="<?php echo $listing_obj->get_permalink(); ?>"><?php _e('view detail', 'enginethemes'); ?></a>

	</div>

	<?php if( !me_get_user_rate_listing_score($listing_obj->ID, $order->post_author) && !$order->has_status('me-pending') ) : ?>
		<a class="me-orderlisting-review" href="<?php echo add_query_arg(array('id' => $listing_obj->ID, 'action' => 'review')); ?>">
			<?php _e('RATE &amp; REVIEW NOW', 'enginethemes'); ?>
		</a>
	<?php endif; ?>
</div>