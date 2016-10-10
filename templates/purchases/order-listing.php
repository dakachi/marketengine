<div class="me-orderlisting-info">
	<a class="me-orderlisting-thumbs" href="<?php echo $listing_obj->get_permalink(); ?>"><?php echo $listing_obj->get_listing_thumbnail(); ?></a>
	<div class="me-listing-info">
		<h2><a href="<?php echo $listing_obj->get_permalink(); ?>"><?php echo esc_html($listing_obj->get_title()); ?></a></h2>
		<div class="me-rating">
			<i class="icon-me-star"></i>
			<i class="icon-me-star"></i>
			<i class="icon-me-star"></i>
			<i class="icon-me-star"></i>
			<i class="icon-me-star-o"></i>
		</div>
		<div class="me-count-purchases-review">
			<span>12 Purchase</span><span>30 review</span>
		</div>
		<p><?php echo $listing_obj->get_description(); ?></p>
		<a class="me-listing-info-view" href="<?php echo $listing_obj->get_permalink(); ?>">view detail</a>
	</div>
	<a class="me-orderlisting-review" href="">RATE &amp; REVIEW NOW</a>
</div>