<?php
/**
 *	The Template for displaying listings posted by the current user.
 * 	This template can be overridden by copying it to yourtheme/marketengine/account/my-listings.php.
 *
 * @author 		EngineThemes
 * @package 	MarketEngine/Templates
 * @version     1.0.0
 */

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$listing_status = isset($_GET['status']) ? $_GET['status'] : 'any';
$args = array(
	'orderby'          => 'date',
	'order'            => 'DESC',
	'post_type'        => 'listing',
	'author'	   	   => get_current_user_id(),
	'post_status'      => $listing_status,
	'paged'			   => $paged,
);

$query = new WP_Query( $args );

?>
	<div class="marketengine-content marketengine-snap-column listing-post">
		<div class="marketengine-filter">
			<div class="marketengine-filter-listing pull-right">
				<div class="filter-listing-status">
					<select name="" id="" onchange="window.location.href='?status=' + this.value;">

					<?php
						$filter_options = me_listings_status_list();
						foreach( $filter_options as $key => $label) :
					?>
						<option value="<?php echo $key; ?>" <?php echo ($listing_status == $key) ? 'selected' : ''; ?>><?php echo $label; ?></option>
					<?php
						endforeach;
					?>
					</select>

				</div>
			</div>
		</div>

		<?php if( $query->have_posts() ): ?>

		<div class="marketengine-listing-post">
			<ul class="me-listing-post me-row">
			<?php
				while($query->have_posts()) : $query->the_post();
					$post_obj = get_post(get_the_ID());
					$listing = new ME_Listing($post_obj);
					$listing_type = $listing->get_listing_type();
					$post_status = get_post_status();
			?>
				<li class="me-item-post me-col-md-3">
					<div class="me-item-wrap">
						<a href="<?php the_permalink(); ?>" class="me-item-img">
							<?php the_post_thumbnail( 'thumbnail' ); ?>
							<span><?php echo __('VIEW DETAILS', 'enginethemes'); ?></span>
							<div class="marketengine-ribbon-<?php echo $post_status; ?>">
								<span class="me-ribbon-content"><?php echo ucfirst($post_status); ?></span>
							</div>
						</a>
						<div class="me-item-content">
							<h2><a href="<?php the_permalink(); ?>"><?php the_excerpt(); ?></a></h2>
							<div class="me-item-price">
							<?php
							if( $listing_type ) :
								if( 'purchasion' !== $listing_type ) :
							?>
								<span class="me-price pull-left"><b><?php echo __('Contact', 'enginethemes'); ?></b></span>
							<?php else : ?>
							<?php
							$purchasion = new ME_Listing_Purchasion($post_obj);
							$price = $purchasion->get_price();
							$pricing_unit = $purchasion->get_pricing_unit();
							?>
								<span class="me-price pull-left">
									<b itemprop="priceCurrency" content="USD">$</b>
									<?php printf(__('<b itemprop="price" content="10">%d</b>%s', 'enginethemes'), $price, $pricing_unit) ?>
								</span>
								<?php /*
								<div class="me-rating pull-right">
									<i class="icon-me-star"></i>
									<i class="icon-me-star"></i>
									<i class="icon-me-star"></i>
									<i class="icon-me-star"></i>
									<i class="icon-me-star-o"></i>
								</div>
								*/ ?>
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
				endwhile;
				wp_reset_postdata();
			?>
			</ul>
			<div class="marketengine-paginations">
				<?php me_paginate_link ($query); ?>
			</div>
		</div>
	</div>
	<!--// marketengine-content -->
<?php
else:
	me_get_template('loop/content-listing-none');
endif;
?>