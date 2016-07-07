<?php 
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
global $wp_query;
?>
<?php  get_header(); ?>

<div id="marketengine-page">
	<div class="me-container marketengine">
		<div class="marketengine-content-wrap">
			<div class="marketengine-page-title">
				<p><?php _e("SHOP", "enginethemes"); ?></p>
			</div>
			<!-- marketengine-content -->
			<div class="marketengine-content">
				<div class="me-row">
					<div class="me-col-md-3">
						<?php do_action('marketengine_listing_sidebar'); ?>
						<div class="me-content-sidebar">
							<form id="me-filter-form" action="">
								<div class="me-sidebar-shop me-sidebar-categories">
									<div class="me-title-sidebar">
										<p>CATEGORIES</p>
									</div>
									<ul class="me-menu-categories">
										<li><a href="#">All</a></li>
										<li class="active">
											<a href="#">Advertive</a>
											<ul class="me-child-categories">
												<li><a href="#">Electrial</a></li>
												<li><a href="#">Electric</a></li>
											</ul>
										</li>
										<li><a href="">Telecommunications</a></li>
										<li><a href="">Auto & Transportation</a></li>
									</ul>
								</div>
								<div class="me-sidebar-shop me-sidebar-listingtype">
									<div class="me-title-sidebar">
										<p>LISTING TYPES</p>
									</div>
									<div class="me-listingtype-filter">
										<label><input type="checkbox" name="">Offering</label>
									</div>
									<div class="me-listingtype-filter">
										<label><input type="checkbox" name="">Selling</label>
									</div>
									<div class="me-listingtype-filter">
										<label><input type="checkbox" name="">Renting Out</label>
									</div>
								</div>
								<div class="me-sidebar-shop me-sidebar-price">
									<div class="me-title-sidebar">
										<p>PRICE</p>
									</div>
									<div class="me-price-filter">
										<div id="me-range-price" min="1" max="500" step="1"></div>
										<div class="me-row">
											<div class="me-col-xs-5"><input class="me-range-price me-range-min" type="number" name="price-min" value=""></div>
											<div class="me-col-xs-2 "><span class="me-range-dash">-</span></div>
											<div class="me-col-xs-5"><input class="me-range-price me-range-max" type="number" name="price-min" value=""></div>
										</div>
									</div>
								</div>
								<div class="me-sidebar-button">
									<input class="me-filter-btn" type="submit" value="Filter">
									<!-- <input class="" type="button" value="Default"> -->
								</div>
							</form>
						</div>
					</div>
					<div class="me-col-md-9 marketengine-snap-column">
						<div class="me-content-shop">
							<div class="me-bar-shop">
								<div class="me-title-shop pull-left">
									<?php
										the_archive_title( '<h2 class="page-title">', '</h2>' );
										the_archive_description( '<div class="taxonomy-description">', '</div>' );
									?>
									<span><?php printf(_n( 'One item in total', "%d items in totals", $wp_query->found_posts, "enginethemes" ), $wp_query->found_posts) ?></span>
								</div>
								<div class="me-sort-listing pull-right">
									<select name="" id="">
										<option value="">Sort items</option>
										<option value="">Low price</option>
										<option value="">Height price</option>
										<option value="">Alphabe name</option>
									</select>
								</div>
							</div>
							<div class="clearfix"></div>
							
							<?php if(have_posts()) : ?>

							<ul class="me-listing-post me-row">
								<?php 
								while (have_posts()) : the_post();
									me_get_template_part('content','listing');
								endwhile;
								?>
							</ul>

							<?php
							else :
								me_get_template_part( 'listing', 'none' );
							endif;
							?>
							<div class="marketengine-paginations">
								<?php me_paginate_link (); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--// marketengine-content -->
	</div>
</div>

<?php get_footer(); ?>