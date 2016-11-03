<?php

$args = array(
	'posts_per_page'	=> 12,
	'post_type' 		=> 'listing',
	'exclude'			=> $curr_listing,
);

if(!empty($listing_cat)) {
	$args['tax_query'] = array();
	foreach ($listing_cat as $key => $cat) {
		$args['tax_query'][] = array(
			'taxonomy' 	=> 'listing_category',
			'field' 	=> 'slug',
			'terms' 	=> $cat,
		);
	}
}

$listings = get_posts( $args );

if(!empty($listings)) :
?>

<div class="marketengine-related-wrap">
	<?php ?>
	<h2><?php _e('You may like these listings', 'enginethemes'); ?></h2>
	<div class="me-related-slider flexslider">
		<ul class="me-related slides">
		<?php
			foreach( $listings as $listing ) :
				$listing = me_get_listing($listing);
				$listing_type = $listing->get_listing_type();
		?>
			<li class="me-item-post">

				<div class="me-item-wrap">

					<a href="#" class="me-item-img">
						<img src="<?php echo $listing->get_listing_thumbnail(); ?>" alt="">
						<span><?php _e('VIEW DETAILS', 'enginethemes'); ?></span>
					</a>

					<div class="me-item-content">
						<h2><a href="<?php echo $listing->get_permalink() ?>"><?php echo $listing->get_title(); ?></a></h2>

						<?php
							if('purchasion' == $listing_type) :
								me_get_template('loop/purchasion', array('listing' => $listing));
							else :
								me_get_template('loop/contact', array('listing' => $listing));
							endif;
						 ?>

						<div class="me-item-author">
						<?php
							$seller = get_userdata( $listing->get_author() );
						?>
							<a href="#"><?php printf( __('<i>by</i>%s'), $seller->display_name ); ?></a>
						</div>
					</div>

				</div>

			</li>

		<?php endforeach; ?>
		</ul>
	</div>
</div>

<?php endif; ?>

<?php wp_reset_postdata(); ?>