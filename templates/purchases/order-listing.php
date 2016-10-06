<?php
	foreach($cart_items as $key => $item) :
		$listing = get_post($item['id']);
?>
<div class="me-orderlisting-info">
	<a class="me-orderlisting-thumbs" href="<?php echo get_the_permalink($listing->ID); ?>"><?php echo get_the_post_thumbnail($listing->ID); ?></a>
	<div class="me-listing-info">
		<h2><a href="<?php echo get_the_permalink($listing->ID); ?>"><?php echo $listing->post_title; ?></a></h2>
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
		<p><?php echo $listing->post_content; ?></p>
		<a class="me-listing-info-view" href="<?php echo get_the_permalink($listing->ID); ?>">view detail</a>
	</div>
	<a class="me-orderlisting-review" href="">RATE &amp; REVIEW NOW</a>
</div>
<?php endforeach; ?>