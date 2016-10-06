<?php
	foreach($cart_items as $key => $item) :
		$listing = me_get_listing(absint( $item['id'] ));
?>
<div class="me-orderlisting-info">
	<a class="me-orderlisting-thumbs" href="<?php echo $listing->get_permalink(); ?>"><?php echo $listing->get_listing_thumbnail(); ?></a>
	<div class="me-listing-info">
		<h2><a href="<?php echo $listing->get_permalink(); ?>"><?php echo $listing->get_title(); ?></a></h2>
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
		<p><?php echo $listing->get_description(); ?></p>
		<a class="me-listing-info-view" href="<?php echo $listing->get_permalink(); ?>">view detail</a>
	</div>
	<a class="me-orderlisting-review" href="">RATE &amp; REVIEW NOW</a>
</div>
<?php endforeach; ?>