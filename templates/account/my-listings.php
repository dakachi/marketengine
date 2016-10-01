<?php
$args = array(
	'orderby'          => 'date',
	'order'            => 'DESC',
	'post_type'        => 'listing',
	'author'	   	   => get_current_user_id(),
	'post_status'      => 'any',
);
global $post;
$posts = get_posts( $args );
?>
		<div class="marketengine-content marketengine-snap-column listing-post">
			<div class="marketengine-filter">
				<div class="marketengine-filter-listing pull-right">
					<div class="filter-listing-status">
						<select name="" id="">
							<option value="">Publish</option>
							<option value="">Pending</option>
							<option value="">Archived</option>
							<option value="">Draft</option>
							<option value="">Paused</option>
						</select>
					</div>
				</div>
			</div>
			<div class="marketengine-listing-post">
				<ul class="me-listing-post me-row">
				<?php
				if( !empty($posts) ):
					foreach( $posts as $post ) : setup_postdata( $post );
						$listing = new ME_Listing($post);
						$listing_type = $listing->get_listing_type();
						$post_status = get_post_status();
				?>
					<li class="me-item-post me-col-md-3">
						<div class="me-item-wrap">
							<a href="<?php the_permalink(); ?>" class="me-item-img">
								<!-- <img src="assets/img/1.jpg" alt=""> -->
								<?php the_post_thumbnail( 'thumbnail' ); ?>
								<span><?php echo __('VIEW DETAILS', 'enginethemes'); ?></span>
								<div class="marketengine-ribbon-publish">
									<span class="me-ribbon-content"><?php echo $post_status; ?></span>
								</div>
							</a>
							<div class="me-item-content">
								<h2><a href="<?php the_permalink(); ?>"><?php the_excerpt(); ?></a></h2>
								<div class="me-item-price">
								<?php
								if( $listing_type ) :
									if( 'purchasion' !== $listing_type ) :
								?>
									<span class="me-price pull-left"><b>Contact</b></span>
								<?php else : ?>
								<?php
								$purchasion = new ME_Listing_Purchasion($post);
								$price = $purchasion->get_price();
								$pricing_unit = $purchasion->get_pricing_unit();
								?>
									<span class="me-price pull-left">
										<b itemprop="priceCurrency" content="USD">$</b>
										<?php printf(__('<b itemprop="price" content="10">%d</b>%s', 'enginethemes'), $price, $pricing_unit) ?>
									</span>
									<div class="me-rating pull-right">
										<i class="icon-me-star"></i>
										<i class="icon-me-star"></i>
										<i class="icon-me-star"></i>
										<i class="icon-me-star"></i>
										<i class="icon-me-star-o"></i>
									</div>
								<?php
									endif;
								endif;
								?>
								</div>
								<div class="me-item-action">
								<?php
									$action_array = array();
									switch ($post_status) {
										case 'publish':
								?>
									<span class="icon-me-pause"></span>
									<span class="icon-me-edit"></span>
									<span class="icon-me-delete"></span>
								<?php
											break;
										case 'archived':
								?>
									<span class="icon-me-action-reopen"></span>
									<span class="icon-me-edit"></span>
									<span class="icon-me-delete"></span>
								<?php
											break;
										case 'pause':
								?>
									<span class="icon-me-resume"></span>
									<span class="icon-me-edit"></span>
									<span class="icon-me-delete"></span>
								<?php
											break;
										default:
								?>
									<span class="icon-me-edit"></span>
									<span class="icon-me-delete"></span>
								<?php
											break;
									}
								?>
								</div>
							</div>
						</div>
					</li>
				<?php
					endforeach;
					wp_reset_postdata();
				else:
					me_get_template('content-listing-none');
				endif;
				?>
				</ul>
				<div class="marketengine-paginations">
					<?php me_paginate_link (); ?>
				</div>
			</div>
		</div>
		<!--// marketengine-content -->